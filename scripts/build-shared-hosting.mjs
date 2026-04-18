import { cpSync, existsSync, mkdirSync, readdirSync, readFileSync, rmSync, writeFileSync } from 'node:fs'
import path from 'node:path'
import { fileURLToPath } from 'node:url'
import { execFileSync } from 'node:child_process'

const __filename = fileURLToPath(import.meta.url)
const __dirname = path.dirname(__filename)
const repoRoot = path.resolve(__dirname, '..')
const cmsRoot = path.join(repoRoot, 'cms-project')
const deployRoot = path.join(repoRoot, 'deploy', 'shared-hosting')
const appDeployRoot = path.join(deployRoot, 'app')
const publicDeployRoot = path.join(deployRoot, 'public_html')
const sourcePublicRoot = path.join(repoRoot, 'public')
const sourceImagesRoot = path.join(sourcePublicRoot, 'images')
const sourceCmsEnvPath = path.join(cmsRoot, '.env')

const ensureDir = (dir) => mkdirSync(dir, { recursive: true })

const normalizeBasePath = (value) => {
  if (!value || value === '/') return '/'

  const withLeadingSlash = value.startsWith('/') ? value : `/${value}`
  return withLeadingSlash.endsWith('/') ? withLeadingSlash : `${withLeadingSlash}/`
}

const parseEnvFile = (filePath) => {
  if (!existsSync(filePath)) return {}

  return readFileSync(filePath, 'utf8')
    .split(/\r?\n/)
    .reduce((env, line) => {
      const trimmed = line.trim()
      if (!trimmed || trimmed.startsWith('#')) return env

      const separatorIndex = trimmed.indexOf('=')
      if (separatorIndex === -1) return env

      const key = trimmed.slice(0, separatorIndex).trim()
      let value = trimmed.slice(separatorIndex + 1).trim()

      if (
        (value.startsWith('"') && value.endsWith('"')) ||
        (value.startsWith("'") && value.endsWith("'"))
      ) {
        value = value.slice(1, -1)
      }

      env[key] = value
      return env
    }, {})
}

const removeIfExists = (target) => {
  if (existsSync(target)) {
    rmSync(target, { recursive: true, force: true })
  }
}

const copyDirectory = (source, destination, filter) => {
  cpSync(source, destination, {
    recursive: true,
    filter: (src) => filter(path.resolve(src)),
  })
}

const isIgnoredAppPath = (targetPath) => {
  const relative = path.relative(cmsRoot, targetPath)
  if (!relative || relative === '') return true

  if (relative === '.env') return false
  if (relative === 'node_modules') return false
  if (relative === 'public') return false
  if (relative === '.git') return false

  const firstSegment = relative.split(path.sep)[0]
  if (firstSegment === 'node_modules' || firstSegment === 'public' || firstSegment === '.git') {
    return false
  }

  if (relative.startsWith(`storage${path.sep}logs`)) return false
  if (relative.startsWith(`storage${path.sep}framework${path.sep}cache`)) return false
  if (relative.startsWith(`storage${path.sep}framework${path.sep}sessions`)) return false
  if (relative.startsWith(`storage${path.sep}framework${path.sep}testing`)) return false
  if (relative.startsWith(`storage${path.sep}framework${path.sep}views`)) return false

  return true
}

const buildFrontend = () => {
  const viteCliPath = path.join(repoRoot, 'node_modules', 'vite', 'bin', 'vite.js')

  if (!existsSync(viteCliPath)) {
    throw new Error('Vite CLI not found. Run "npm install" in the repository root first.')
  }

  execFileSync(process.execPath, [viteCliPath, 'build'], {
    cwd: repoRoot,
    stdio: 'inherit',
    shell: false,
  })
}

const writeLocalTestEnv = () => {
  const shouldGenerateLocalEnv = ['1', 'true', 'yes'].includes(
    String(process.env.SHARED_HOSTING_GENERATE_LOCAL_ENV || '').toLowerCase()
  )

  if (!shouldGenerateLocalEnv) return

  const sourceEnv = parseEnvFile(sourceCmsEnvPath)
  const appBasePath = normalizeBasePath(process.env.VITE_APP_BASE_PATH)
  const derivedAppUrl = process.env.SHARED_HOSTING_LOCAL_APP_URL || `http://localhost${appBasePath === '/' ? '' : appBasePath.slice(0, -1)}`
  const localCorsOrigin =
    process.env.SHARED_HOSTING_LOCAL_CORS_ORIGIN ||
    new URL(derivedAppUrl).origin
  const appKey = process.env.SHARED_HOSTING_LOCAL_APP_KEY || sourceEnv.APP_KEY || ''
  const databasePath = path.join(appDeployRoot, 'database', 'database.sqlite').replace(/\\/g, '/')

  const localEnv = `APP_NAME=LutongBahayCMS
APP_ENV=local
APP_KEY=${appKey}
APP_DEBUG=true
APP_URL=${derivedAppUrl}

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=sqlite
DB_DATABASE=${databasePath}

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DRIVER=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120
SESSION_SECURE_COOKIE=false

CORS_ALLOWED_ORIGIN=${localCorsOrigin}
`

  writeFileSync(path.join(appDeployRoot, '.env'), localEnv, 'utf8')
}

const prepareAppTree = () => {
  copyDirectory(cmsRoot, appDeployRoot, isIgnoredAppPath)

  const appEnvExample = path.join(appDeployRoot, '.env.example')
  const productionEnvExample = path.join(appDeployRoot, '.env.production.example')
  if (existsSync(productionEnvExample)) {
    cpSync(productionEnvExample, appEnvExample)
  }

  ;[
    path.join(appDeployRoot, 'storage', 'logs'),
    path.join(appDeployRoot, 'storage', 'framework', 'cache'),
    path.join(appDeployRoot, 'storage', 'framework', 'sessions'),
    path.join(appDeployRoot, 'storage', 'framework', 'testing'),
    path.join(appDeployRoot, 'storage', 'framework', 'views'),
  ].forEach(ensureDir)
}

const preparePublicTree = () => {
  const sourcePublic = path.join(cmsRoot, 'public')
  copyDirectory(sourcePublic, publicDeployRoot, () => true)

  if (existsSync(sourceImagesRoot)) {
    cpSync(sourceImagesRoot, path.join(publicDeployRoot, 'images'), {
      recursive: true,
    })
  }

  const indexPhpPath = path.join(publicDeployRoot, 'index.php')
  const indexPhp = readFileSync(indexPhpPath, 'utf8')
    .replace("__DIR__.'/../vendor/autoload.php'", "__DIR__.'/../app/vendor/autoload.php'")
    .replace("__DIR__.'/../bootstrap/app.php'", "__DIR__.'/../app/bootstrap/app.php'")
    .replace("__DIR__.'/../storage/framework/maintenance.php'", "__DIR__.'/../app/storage/framework/maintenance.php'")
    .replace(
      "$app = require_once __DIR__.'/../app/bootstrap/app.php';",
      "$app = require_once __DIR__.'/../app/bootstrap/app.php';\n$app->bind('path.public', fn () => __DIR__);"
    )
  writeFileSync(indexPhpPath, indexPhp)

  const htaccessPath = path.join(publicDeployRoot, '.htaccess')
  const existingHtaccess = readFileSync(htaccessPath, 'utf8')
  const extraRules = `

# Shared hosting hardening
<FilesMatch "^\\.env">
    Require all denied
</FilesMatch>
`
  writeFileSync(htaccessPath, `${existingHtaccess.trimEnd()}${extraRules}`)
}

const writeReadme = () => {
  const readmePath = path.join(deployRoot, 'README.txt')
  const filesInPublic = readdirSync(publicDeployRoot).join(', ')

  writeFileSync(
    readmePath,
    `Lutong Bahay shared hosting package

Contents
- app/: upload this whole folder outside public_html if your host allows it.
- public_html/: upload the contents of this folder into your web root.

Recommended shared hosting layout
- /home/USERNAME/app
- /home/USERNAME/public_html

Steps
1. FTP upload deploy/shared-hosting/app to a non-public folder on the server.
2. FTP upload deploy/shared-hosting/public_html/* into public_html.
3. On the server, copy app/.env.example to app/.env and fill in:
   - APP_KEY
   - APP_URL
   - DB_DATABASE
   - CORS_ALLOWED_ORIGIN
4. Make sure these folders are writable by PHP:
   - app/storage
   - app/bootstrap/cache
5. If your host supports terminal access, run:
   - php artisan key:generate
   - php artisan migrate --force
   - php artisan config:cache
   - php artisan route:cache

Notes
- This package already contains the built Vue frontend in public_html/frontend.
- public_html/index.php is pre-adjusted to load Laravel from ../app.
- If your host forces a different folder layout, update public_html/index.php paths to match.
- If the host does not provide SSH, generate APP_KEY locally and paste it into app/.env before uploading.

Files in public_html
- ${filesInPublic}
`,
    'utf8',
  )
}

removeIfExists(deployRoot)
ensureDir(deployRoot)

buildFrontend()
prepareAppTree()
preparePublicTree()
writeLocalTestEnv()
writeReadme()

console.log(`\nShared hosting package created at ${deployRoot}`)

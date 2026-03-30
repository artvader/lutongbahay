export type Difficulty = 'Easy' | 'Medium' | 'Hard'

export type Recipe = {
  id: string
  slug: string
  title: string
  description: string
  imageUrl: string
  imageAlt: string
  prepMins: number
  cookMins: number
  difficulty: Difficulty
  rating: number
  ratingCount: number
  region: string
  course: string
  mainIngredient: string
  featured?: boolean
  ingredients: string[]
  steps: string[]
}

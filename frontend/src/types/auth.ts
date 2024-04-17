export type User = {
  id: number
  username: string
  role: string
  points: number
}

export type JWTUser = {
  id: number
  a_username: string
  a_emailaddress: string
  a_role: string
}

export type Session = {
  user: User | null
  token: string | null
  expiresAt: Date | null
}

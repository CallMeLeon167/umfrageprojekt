export type User = {
  id: number
  username: string
  email?: string
  votes?: number
  role?: UserRole
  points?: number
}

export type JWTUser = {
  id: number
  a_username: string
  a_emailaddress: string
  a_role: string
}

export enum UserRole {
  Admin = 'Admin',
  Kunde = 'Kunde',
  Guest = 'Gast'
}

export type Session = {
  user: User | null
  token: string | null
  expiresAt: Date | null
}

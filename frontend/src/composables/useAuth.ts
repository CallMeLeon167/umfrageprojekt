import type { JWTUser, Session, User } from '@/types/auth'
import { ofetch } from 'ofetch'
import { ref } from 'vue'

const API_URL = import.meta.env.VITE_API_URL

export function useAuth() {
  const session = ref(<Session>{})

  async function login(username: string, password: string) {
    try {
      const response = await fetch(API_URL + '/login', {
        method: 'POST'
      })
    } catch (error) {
      console.error(error)
    }
  }

  return { session, login }
}

function parseUserFromJWT(jwt: string): User | null {
  try {
    const jwtUser = JSON.parse(atob(jwt.split('.')[1])) as JWTUser
    const user: User = {
      id: jwtUser.id,
      username: jwtUser.a_username,
      role: jwtUser.a_role,
      points: 0
    }
    return user
  } catch (error) {
    console.error(error)
    return null
  }
}

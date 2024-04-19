import type { JWTUser, Session, User } from '@/types/auth'
import { ofetch } from 'ofetch'
import { reactive, ref } from 'vue'

const API_URL = import.meta.env.VITE_API_URL

const session = reactive({
  user: null as User | null,
  token: null as string | null,
  expiresAt: null as Date | null
})

export function useAuth() {
  async function login(username: string, password: string) {
    try {
      console.log('API URL: ' + API_URL)
      const response = await ofetch('/login', {
        baseURL: API_URL,
        method: 'POST',
        body: { username: username, password: password }
      })
      if (response) {
        const token = response?.token ?? null
        const user = parseUserFromJWT(token)
        session.user = user
        session.token = token
      } else {
        console.error('Login failed:', response.status, response.statusText)
      }
    } catch (error) {
      console.error(error)
    }
  }

  function logout() {
    session.user = null
    session.token = null
    session.expiresAt = null
  }

  return { session, login, logout }
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

import { type UserRole, type JWTUser, type Session, type User } from '@/types/auth'
import { ofetch } from 'ofetch'
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'

const API_URL = import.meta.env.VITE_API_URL

const session = reactive({
  user: null as User | null,
  token: null as string | null,
  expiresAt: null as Date | null
})

export function useAuth() {

  const router = useRouter();

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
        // save token to local storage
        localStorage.setItem('token', token);
        // redirect to home page
        await router.push('/')

      } else {
        console.error('Login failed:', response.status, response.statusText)
      }
    } catch (error) {
      console.error(error)
    }
  }

  function loginFromLocalStorage() {
    const token = localStorage.getItem('token')
    if (token) {
      console.log('Token found in local storage. Logging in...')
      const user = parseUserFromJWT(token)
      session.user = user
      session.token = token
    }
  }

  function logout() {
    session.user = null
    session.token = null
    session.expiresAt = null
    // remove token from local storage
    localStorage.removeItem('token')
  }

  return { session, login, logout, loginFromLocalStorage }
}

function parseUserFromJWT(jwt: string): User | null {
  try {
    const jwtUser = JSON.parse(atob(jwt.split('.')[1])) as JWTUser
    const user: User = {
      id: jwtUser.id,
      username: jwtUser.a_username,
      role: jwtUser.a_role as UserRole,
      points: 0
    }
    return user
  } catch (error) {
    console.error(error)
    return null
  }
}

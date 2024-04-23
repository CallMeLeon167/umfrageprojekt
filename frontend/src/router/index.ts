import { createRouter, createWebHistory } from 'vue-router'
import HomePage from '@/page/home.vue'
import SurveysListVue from '@/page/SurveysList.vue'
import SurveyDetailVue from '@/page/SurveyDetail.vue'
import AdminIndex from '@/page/admin/AdminIndex.vue'
import AdminCategory from "@/page/admin/AdminCategory.vue";
import SurveyCreateVue from '@/page/SurveyCreate.vue'
import LoginPage from '@/page/Login.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'index',
      component: HomePage,
      meta: {
        title: 'Startseite'
      }
    },
    {
      path: "/admin",
      name: "admin",
      component: AdminIndex,
      meta: {
        title: 'Umfrageprojekt Administration'
      },
      children: [
        {
          path: "category",
          name: "admin-categories",
          component: AdminCategory,
        }
      ]
    },
    {
      path: '/login',
      name: 'login',
      component: LoginPage,
      meta: {
        title: 'Login'
      }
    },
    {
      // list of all surveys
      path: '/survey/list',
      name: 'survey-list',
      component: SurveysListVue,
      meta: {
        title: 'Umfragen'
      }
    },
    {
      // detail of a survey (results, questions, etc.)
      path: '/survey/detail/:id',
      name: 'survey-detail',
      component: SurveyDetailVue,
      meta: {
        title: 'Umfrage'
      }
    },
    {
      // create a new survey
      path: '/survey/create',
      name: 'survey-create',
      component: SurveyCreateVue,
      meta: {
        title: 'Umfrage erstellen'
      }
    }
  ]
})

export default router
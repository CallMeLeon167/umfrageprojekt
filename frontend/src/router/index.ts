import { createRouter, createWebHistory } from 'vue-router'
import HomePage from '@/pages/Home.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'index',
      component: HomePage
    }
    // {
    //   // list of all surveys
    //   path: '/survey/list',
    //   name: 'survey-list',
    //   component: () => import('@/pages/SurveyList.vue')
    // },
    // {
    //   // detail of a survey (results, questions, etc.)
    //   path: '/survey/detail/:id',
    //   name: 'survey-detail',
    //   component: () => import('@/pages/SurveyDetail.vue')
    // },
    // {
    //   // fill out a survey
    //   path: '/survey/fill/:id',
    //   name: 'survey-fill',
    //   component: () => import('@/pages/SurveyFill.vue')
    // },
    // {
    //   // create a new survey
    //   path: '/survey/create',
    //   name: 'survey-create',
    //   component: () => import('@/pages/SurveyCreate.vue')
    // }
  ]
})

export default router

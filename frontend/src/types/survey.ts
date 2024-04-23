export enum SurveyState {
    OPEN = 'open',
    CLOSED = 'closed',
    DRAFT = 'draft'
}

export enum SurveyQuestionType {
    TEXT = 'text',
    MULTIPLE_CHOICE = 'multiple_choice',
    SINGLE_CHOICE = 'single_choice'
}

export type Survey = {
    id: string
    topic: string
    type: string
    startDate: Date
    endDate: Date
    status: SurveyState
    categoryID: string
    questions?: SurveyQuestion[]
}

export type SurveyQuestion = {
    id?: string
    surveyId?: string
    survey?: Survey | undefined
    text: string
    type: SurveyQuestionType
    options: SurveyAnswerOption[]
}

export type SurveyAnswerOption = {
    id?: string
    questionId?: string
    question?: SurveyQuestion | undefined
    text: string
    type: SurveyQuestionType
}

export type SurveyAnswer = {
    id: string
    questionId: string
    question: SurveyQuestion | undefined
    answerId: string
    answer: SurveyAnswerOption | undefined
}

export type Category = {
    id: string
    name: string
    type: string
    surveys?: Survey[]
}
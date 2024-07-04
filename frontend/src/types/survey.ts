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
  id: string;
  topic: string;
  type: string;
  startdate: Date;
  enddate: Date;
  status: SurveyState;
  categoryID: string;
  questions?: SurveyQuestion[];
};

export type SurveyEvaluation = [
    {
      SurveyID: string;
      Question: string;
      QuestionId: string;
      AnswerOptionId: string;
      AnswerOption: string;
      UserResponse: string;
      Username: string;
    }
];

export type SurveyQuestion = {
  questionId?: string;
  questionText: string;
  questionType: SurveyQuestionType;
  questionOrder: number;
  answerOptions: SurveyAnswerOption[];
  questionSurveyID?: string;
  survey?: Survey | undefined;
};

export type SurveyAnswerOption = {
  answerOptionID?: string;
  answerOptionOrder: number;
  answerOptionText: string;
  answerOptionQuestionID?: string;
  question?: SurveyQuestion | undefined;
  type: SurveyQuestionType;
};

export type SurveyAnswer = {
  id: string;
  questionId: string;
  question: SurveyQuestion | undefined;
  answerId: string;
  answer: SurveyAnswerOption | undefined;
};

export type Category = {
  id: string;
  name: string;
  type: string;
  surveys?: Survey[];
};

export type Comment = {
  commentID: string;
  accountID: string;
  commentText: string;
  likeCount: number;
  constitutionDate: Date;
  surveyID: string;
  accountName?: string | undefined;
};

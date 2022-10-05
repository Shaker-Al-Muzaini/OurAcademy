<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;
use Modules\Quiz\Entities\QuizTest;

class MyReportQuizPageSection extends Component
{

    public function __construct()
    {
        //
    }

    public function render()
    {
        $quizzes = QuizTest::with(['course', 'quiz', 'user'])->latest()->where('user_id', Auth::id())->paginate(5);
        return view(theme('components.my-report-quiz-page-section'), compact('quizzes'));
    }
}

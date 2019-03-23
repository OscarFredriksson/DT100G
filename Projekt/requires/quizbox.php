<?php
    class QuizBox
    {
        private $quizID;
        private $title;
        private $descr;

        function __construct($quizID, $title, $descr)
        {
            $this->quizID = $quizID;
            $this->title = $title;
            $this->descr = $descr;
        }

        function place()
        {
            echo '<li><div class="quizbox"> <div class="upper">';
            echo '<p class="title">' . $this->title . '</p>';
            echo '<i class="material-icons icon">more_vert</i></div>';

            echo '<p class="descr">' . $this->descr . '</p>';
                    
            echo '  <div class="lower">
                        <input type="button" class="play-btn hover-highlight" value="spela" onclick="playButtonClicked(this)" id="' . $this->quizID . '">
                    </div> </div></li>';
        }
    }
?>
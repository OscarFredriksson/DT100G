<?php
    class QuizBox
    {
        private $quizID;

        function __construct($quizID)
        {
            $this->quizID = $quizID;
        }

        function place()
        {
            echo '<div class="quizbox">
                    <div class="upper">
                        <p class="title"> Quizets Titel </p>
                        <i class="material-icons icon">more_vert</i>
                    </div>

                    <p class="descr"> Lorem ipsum dolor sit amet, consectetur adipisicing elit, 
                        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. <p>
                    
                    <div class="lower">
                        <input type="button" class="play-btn" value="spela" onclick="playButtonClicked(this)" id="' . $this->quizID . '">
                    </div>
                </div>';
        }
    }
?>
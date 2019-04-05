<?php
    /*
        Denna fil innehåller två klasser, en fråga och ett alternativ, som tillsammans utgör 
        grunden för ett quiz. 

        Question-klassen innehåller frågans text, en lista med alla alternativ till frågan,
        samt spelarens svar på frågan när detta blir relevant. Klassen innehåller funktioner 
        för att t.ex hämta frågans text, eller hämta det korrekta alternativet. 

        Alternative-klassen innehåller dess text samt om det är ett korrekt svar eller inte,
        denna används i question-klassens lista med alternativ. 

        All kod är skriven av Oscar Fredriksson 
    */

    interface QuestionInterface
    {
        function __construct($text);            //Konstruera en fråga med given text 
        function addAlternative($alternative);  //Lägg till ett alternativ till frågan
        function getText();                     //Hämta frågans text
        function getAlternatives();             //Hämta alla alternativ 
        function addAnswer($answer);            //Lägg till användarens svar på frågan
        function getAnswer();                   //Hämta användarens svar på frågan
        function getCorrectAlternative();       //Hämta det korrekta alternativet
    }


    class Question implements QuestionInterface
    {
        private $text;   //Frågans text (alltså själva frågan)
        
        private $alternatives = Array();    //En lista med alla alternativ till frågan, använder alternativ-klassen endan
        
        private $answer;    //Spelarens svar på frågan

        function __construct($text) //Konstruera en fråga med given text
        {
            $this->text = $text;    
        }

        function addAlternative($alternative)   //Lägg till ett alternativ till frågan, inargumentet är ett Alternative-objekt av klassen nedan
        {
            $this->alternatives[] = $alternative;   //Lägg till alternativet i listan
        }

        function getText()  //Hämta frågans text
        {
            return $this->text;
        }

        function getAlternatives()  //Hämta alla alternativ
        {
            shuffle($this->alternatives);   //blanda alternativen så dem inte kommer i samma ordning varje gång
            
            return $this->alternatives;
        }

        function addAnswer($answer) //Lägg till användarens svar på frågan
        {
            $this->answer = $answer;
        }

        function getAnswer()    //Hämta användarens svar på frågan
        {
            return $this->answer;
        }

        function getCorrectAlternative()    //Hämta det korrekta alternativet
        {
            foreach($this->alternatives as $alternative)    //Gå igenom alla alternativ tills det som är korrekt har hittats
            {
                if($alternative->is_correct)    return $alternative;
            }

            die("Error: Korrupt Quiz - Hittade inget rätt svar.");  //Om den loopar igenom alla utan att hitta något, skriv felmeddelande
        }
    }

    class Alternative
    {
        public $text;       //Alternativets text
        public $is_correct; //Om alternativet är korrekt eller inte

        function __construct($text, $is_correct)    //Konstruera ett alternativ
        {
            $this->text = $text;
            $this->is_correct = $is_correct;
        }
    }

?>
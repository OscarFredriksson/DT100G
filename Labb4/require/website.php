<?php
    interface WebsiteInterface
    {
        function setPart($part);
        function getPart();
        function setDataLocation($dataLocation);
        function getDataLocation();

        function createHead();
        function createHeader();

        function createLeftColumn();
        function createRightColumn();

        function create_entry_box($id, $name, $date, $message);

        function addEntry($name, $message);
        function deleteEntry($id);

        function createFooter();

        function importScripts();
    }

    class Website implements WebsiteInterface
    {
        private $part;
        private $dataLocation;

        function setPart($part)
        {
            $this->part = $part;
        }

        function getPart()
        {
            return $this->part;
        }

        function setDataLocation($dataLocation)
        {
            $this->dataLocation = $dataLocation;
        }

        function getDataLocation()
        {
            return $this->data;
        }

        function createHead()
        {
            echo    '<head> 
                        <meta charset="utf-8">
                        <link rel="stylesheet" type="text/css" href="css/style.css">
                        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto"> 
                        <title> Labb4 </title>
                    </head>';
        }

        function createHeader()
        {
            echo '<header> <h1 class="header-title"> LABORATION 4 </h1> <ul class="nav">';
            
            if($this->part == 1)    echo '<li class="active">'; 
            else                    echo '<li>';                
            echo '<input type=button id="part1_btn" value="DEL 1"> </li>';  
            
            if($this->part == 2)  echo '<li class="active">'; 
            else                echo '<li>';              
            echo '<input type=button id="part2_btn" value="DEL 2"> </li> </ul> </header>';
        }

        function createLeftColumn()
        {
            echo    '<div class="left-column">
                        <form method="post">
                            <ul class="entry" >
                                <li>
                                    <input type="text" name="name" placeholder="Namn">
                                </li>

                                <li class="message">
                                    <textarea type="text" name="message" placeholder="Meddelande"></textarea>
                                </li>
                                
                                <li class="button">
                                    <input type="submit" name="Skicka">
                                </li>
                        </form>
                    </div>';
        }

        function createRightColumn()
        {
            echo '<div class="right-column"> <ul class="box-list">';

            $data = $this->dataLocation->get_all();
                                
            foreach($data as $entry)
            {
                $this->create_entry_box($entry[0], $entry[1], $entry[3], $entry[2]);
            }
                            
            echo '</ul> </div>';
        }

        function create_entry_box($id, $name, $date, $message)
        {   
            echo "<li class='flat-box'>";
            echo "<div class='upper-text'>";
            echo "<p>".$name."</p>";
            echo "<p>".$date."</p>";
            echo "</div>";
            echo "<hr>";
            echo "<p class='lower-text'>".$message."</p>";
            echo "<hr>";
            echo "<input type='button' class='button'";
            echo "id='".$id. "'";
            echo "onclick='buttonClicked(this)'";
            echo "value='Radera'>";
            echo "</li>";
        }

        function addEntry($name, $message)
        {
            if(empty($name))
            {
                echo '<script> alert("Du måste fylla i ett namn"); </script>';
            }
            else if(empty($message))
            {
                echo '<script> alert("Du kan inte lämna ett tomt meddelande"); </script>';
            }
            else
            {
                $this->dataLocation->add($name, $message);
                
                header("Location: index.php?part=" . $this->getPart());
            }     
        }

        function deleteEntry($id)
        {
            $this->dataLocation->delete($id);
        }

        function importScripts()
        {
            echo '<script src="js/script.js"></script>';
        }

        

        function createFooter()
        {
            echo    '<footer>
                        <p> Laboration 4 </p>
                        <p> Oscar Fredriksson </p>
                        <p> osfr1701@student.miun.se </p>
                    </footer>';
        }
    }

?>
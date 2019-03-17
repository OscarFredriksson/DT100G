<footer>
    <ul>
        <li>Oscar Fredriksson</li>
        <li>osfr1701@student.miun.se</li>
        <li id="lastModified">Senast ändrad: 
            <?php 
                setlocale(LC_ALL, "sv_SE");

                echo strftime("%e %B %Y %H:%M:%S", get_page_mod_time()); 
            ?> 
        </li>

    </li>
</footer>

<?php 
    function get_page_mod_time() 
    { 
        $incls = get_included_files(); 
        $incls = array_filter($incls, "is_file"); 
        $mod_times = array_map('filemtime', $incls); 
        $mod_time = max($mod_times); 

        return $mod_time; 
    } 
?>
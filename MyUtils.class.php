<?php

class MyUtils
{
    static function html_header($title = "Untitled", $style = "")
    {
        $string = <<<END
        <!DOCTYPE HTML>
        <html lang="en">
            <head>
                <title>$title</title>
                <link href="assets/css/$style" rel="stylesheet" type="text/css">
        
            </head>
        
            <body>
            \n
        END;


        return $string;
    }

    static function admin_header($title = "Untitled", $style = "", $page = "", $url = "")
    {

        require_once "DB.class.php";
        $db = new DB();
        //delete user
        $id = "";
        $data = [];
        
        $data = $db->viewInvite($url);
        if($data == null){
            echo '<style>
            .icon {display: none;}
            .icon1 {display: inline-block;}
            </style>';
        }
        else{
            echo '<style>
            .icon1 {display: none;}
            .icon {display: inline-block;}
            </style>';
        }

    
        $string = <<<END
        <!DOCTYPE HTML>
        <html lang = "en">
            <head>
                <title>$title</title>
                <link href="assets/css/$style" rel="stylesheet" type="text/css">
                <!-- Font Awesome Icon Library -->
                <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
                <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            </head>
            <body>
                <div class="header">
                    <div class="logo">
                    </div>
                    <a href="#" class="nav-trigger"><span></span></a>
                    <div class="dropdown" id = "notice" >
                    <button class="dropbtn" onclick="window.location.href='viewInvite.php?id=$url';" ><img class= "icon" src="assets/images/bell.png" alt="icon" /><img class= "icon1" src="assets/images/bell1.png" alt="icon" /></button>
                </div>
            
                <div class="side-nav">
                    <div class="logo">
                        <i class="fa fa-tachometer"></i>
                    </div>
                    <ul>
                        <li>
                            <a href="myPLS.php?id=$url">
                            <span><img src="assets/images/logo1.png" alt="icon" /></span> 
                                <span>myPLS</span>
                            </a>
                        </li>
                        <li>
                            <a href="admin.php?id=$url">
                            <span><i class="fa fa-bar-chart"></i></span>    
                            <span>My Details</span>
                            </a>
                        </li>
                        <li>
                            <a href="viewAllRating.php?id=$url">
                            <span class="fa fa-star"></span>
                            <span>View Feedback</span>
                            </a>
                        </li>
                        <li>
                            <a href="addFeedback.php?id=$url">
                                <span><i class="material-icons">border_color</i></span>
                                <span>Add Feedback</span>
                            </a>
                        </li>
                        <li>
                            <a href="viewGroups.php?id=$url">
                                <span><img src="assets/images/group.png" alt="icon" /></span>
                                <span>View Groups</span>
                            </a>
                        </li>
                        <li>
                        <a href="addDiscussion.php?id=$url">
                            <span><img src="assets/images/add.png" alt="icon" /></span>
                            <span>Add Groups</span>
                        </a>
                        </li>
                        <li>
                            <a href="viewMyGroups.php?id=$url">
                                <span><img src="assets/images/diss.png" alt="icon" /></span>
                                <span>My Groups</span>
                            </a>
                        </li>
                        <li>
                            <a href="viewAllCourse.php?id=$url">
                                <span><img src="assets/images/c.png" alt="icon" /></span>
                                <span>view Course</span>
                            </a>
                        </li>
                        <li>
                            <a href="addCourse.php?id=$url">
                                <span><i class="material-icons">border_color</i></span>
                                <span>Add Course</span>
                            </a>
                        </li>
                        <li>
                            <a href="log_out.php?id=$url">
                                <span><img src="assets/images/logout.png" alt="icon" /></span>
                                <span>Logout</span>
                            </a>
                        </li>
                        </div> 
                    </ul>
                </nav>
            </div>
            <div class="main-content">
            <h1>$page</h1>\n
        END;
        return $string;
    } //end function

    static function student_header($title = "Untitled", $style = "", $page = "", $url = "")
    {

        require_once "DB.class.php";
        $db = new DB();
        //delete user
        $id = "";
        $data = [];
        
        $data = $db->viewInvite($url);
        if($data == null){
            echo '<style>
            .icon {display: none;}
            .icon1 {display: inline-block;}
            </style>';
        }
        else{
            echo '<style>
            .icon1 {display: none;}
            .icon {display: inline-block;}
            </style>';
        }
    
        $string = <<<END
        <!DOCTYPE HTML>
        <html lang = "en">
            <head>
                <title>$title</title>
                <link href="assets/css/$style" rel="stylesheet" type="text/css">
                <!-- Font Awesome Icon Library -->
                <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
                <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            </head>
            <body>
                <div class="header">
                    <div class="logo">
                    </div>
                    <a href="#" class="nav-trigger"><span></span></a>
                    <div class="dropdown" id = "notice" >
                    <button class="dropbtn" onclick="window.location.href='viewInvite.php?id=$url';" ><img class= "icon" src="assets/images/bell.png" alt="icon" /><img class= "icon1" src="assets/images/bell1.png" alt="icon" /></button>
                </div>
            
                <div class="side-nav">
                    <div class="logo">
                        <i class="fa fa-tachometer"></i>
                    </div>
                    <ul>
                        <li>
                            <a href="myPLS.php?id=$url">
                            <span><img src="assets/images/logo1.png" alt="icon" /></span> 
                                <span>myPLS</span>
                            </a>
                        </li>
                        <li>
                            <a href="admin.php?id=$url">
                            <span><i class="fa fa-bar-chart"></i></span>    
                            <span>My Details</span>
                            </a>
                        </li>
                        <li>
                            <a href="viewAllRating.php?id=$url">
                            <span class="fa fa-star"></span>
                            <span>View Feedback</span>
                            </a>
                        </li>
                        <li>
                            <a href="addFeedback.php?id=$url">
                                <span><i class="material-icons">border_color</i></span>
                                <span>Add Feedback</span>
                            </a>
                        </li>
                        <li>
                            <a href="viewGroups.php?id=$url">
                                <span><img src="assets/images/group.png" alt="icon" /></span>
                                <span>View Groups</span>
                            </a>
                        </li>
                        <li>
                        <a href="addDiscussion.php?id=$url">
                            <span><img src="assets/images/add.png" alt="icon" /></span>
                            <span>Add Groups</span>
                        </a>
                        </li>
                        <li>
                            <a href="viewMyGroups.php?id=$url">
                                <span><img src="assets/images/diss.png" alt="icon" /></span>
                                <span>My Groups</span>
                            </a>
                        </li>
                        <li>
                            <a href="viewAllCourse.php?id=$url">
                                <span><img  src="assets/images/c.png" alt="icon" /></span>
                                <span>view Course</span>
                            </a>
                        </li>
                        <li>
                            <a href="addCourse.php?id=$url">
                                <span><i class="material-icons">border_color</i></span>
                                <span>Add Course</span>
                            </a>
                        </li>
                        <li>
                            <a href="log_out.php?id=$url">
                                <span><img src="assets/images/logout.png" alt="icon" /></span>
                                <span>Logout</span>
                            </a>
                        </li>
                        </div> 
                    </ul>
                </nav>
            </div>
            <div class="main-content">
            <h1>$page</h1>\n
        END;
        return $string;
    } //end function

    static function professor_header($title = "Untitled", $style = "", $page = "", $url = "")
    {

        require_once "DB.class.php";
        $db = new DB();
        //delete user
        $id = "";
        $data = [];
        
        $data = $db->viewInvite($url);
        if($data == null){
            echo '<style>
            .icon {display: none;}
            .icon1 {display: inline-block;}
            </style>';
        }
        else{
            echo '<style>
            .icon1 {display: none;}
            .icon {display: inline-block;}
            </style>';
        }

    
        $string = <<<END
        <!DOCTYPE HTML>
        <html lang = "en">
            <head>
                <title>$title</title>
                <link href="assets/css/$style" rel="stylesheet" type="text/css">
                <!-- Font Awesome Icon Library -->
                <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
                <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
                <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
            </head>
            <body>
                <div class="header">
                    <div class="logo">
                    </div>
                    <a href="#" class="nav-trigger"><span></span></a>
                    <div class="dropdown" id = "notice" >
                    <button class="dropbtn" onclick="window.location.href='viewInvite.php?id=$url';" ><img class= "icon" src="assets/images/bell.png" alt="icon" /><img class= "icon1" src="assets/images/bell1.png" alt="icon" /></button>
                </div>
            
                <div class="side-nav">
                    <div class="logo">
                        <i class="fa fa-tachometer"></i>
                    </div>
                    <ul>
                        <li>
                            <a href="myPLS.php?id=$url">
                            <span><img  src="assets/images/logo1.png" alt="icon" /></span> 
                                <span>myPLS</span>
                            </a>
                        </li>
                        <li>
                            <a href="admin.php?id=$url">
                            <span><i class="fa fa-bar-chart"></i></span>    
                            <span>My Details</span>
                            </a>
                        </li>
                        <li>
                            <a href="viewAllRating.php?id=$url">
                            <span class="fa fa-star"></span>
                            <span>View Feedback</span>
                            </a>
                        </li>
                        <li>
                            <a href="addFeedback.php?id=$url">
                                <span><i class="material-icons">border_color</i></span>
                                <span>Add Feedback</span>
                            </a>
                        </li>
                        <li>
                            <a href="viewGroups.php?id=$url">
                                <span><img src="assets/images/group.png" alt="icon" /></span>
                                <span>View Groups</span>
                            </a>
                        </li>
                        <li>
                        <a href="addDiscussion.php?id=$url">
                            <span><img src="assets/images/add.png" alt="icon" /></span>
                            <span>Add Groups</span>
                        </a>
                        </li>
                        <li>
                            <a href="viewMyGroups.php?id=$url">
                                <span><img  src="assets/images/diss.png" alt="icon" /></span>
                                <span>My Groups</span>
                            </a>
                        </li>
                        <li>
                            <a href="viewAllCourse.php?id=$url">
                                <span><img src="assets/images/c.png" alt="icon" /></span>
                                <span>view Course</span>
                            </a>
                        </li>
                        <li>
                            <a href="addCourse.php?id=$url">
                                <span><i class="material-icons">border_color</i></span>
                                <span>Add Course</span>
                            </a>
                        </li>
                        <li>
                            <a href="log_out.php?id=$url">
                                <span><img src="assets/images/logout.png" alt="icon" /></span>
                                <span>Logout</span>
                            </a>
                        </li>
                        </div> 
                    </ul>
                </nav>
            </div>
            <div class="main-content">
            <h1>$page</h1>\n
        END;
        return $string;
    } //end function




    static function html_footer()
    {
        $string = "</div>\n<footer>
        <h4>ⓒ 2021 Star Inc | myPLS</h4><br>
      </footer>\n</body>\n</html>";
        return $string;
    }
    static function html_footer1()
    {
        $string = "\n<footer>
        <h3>ⓒ 2021 Star Inc | myPLS</h3><br>
      </footer>\n</body>\n</html>";
        return $string;
    }
}

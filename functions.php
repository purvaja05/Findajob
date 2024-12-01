<?php
require_once("dbconn.php");

//test();

function test()
{
    global $conn;
    $stmt=$conn->prepare("SELECT * FROM `categories`");
    if($stmt)
    {
        if($stmt->execute())
        {
             $result= $stmt->get_result();
             while($row=$result->fetch_assoc())
             {
             print_r($row);
             echo "<br>";
             }

        }else{
           echo $conn->connect_error;
        }

    }else{
        echo $conn->connect_error;
    }
    
    
    
    
    /*if($stmt){
        $stmt->bind_param("i",$cardid);
        if($stmt->execute()){
            $result=$stmt->get_result();
            while($row=$result->fetch_assoc())
            {
                //print_r($row);
                if($row["tag"]=="select"){
                    $options=getOptions($row["id"]);
                    $row["options"]=$options;
                }


                array_push($fields,$row);
            }
             
            //print_r($fields);
           return $fields;
        }else{
            echo "Execute Error";
        }
    }else{
        echo "Prepare Error";
    }
    */
}



function apply($exp,$package,$loc,$skills)
{
    return "Apply Success";
}

function login($username, $password)
{
    if ($username == "admin" && $password == "admin") {
        session_start();
        $_SESSION["login"] = true;
        $_SESSION["username"] = "admin";
        $result = array("result" => 1, "message" => "Login Successful");
    } else {
        $result = array("result" => 0, "message" => "Invalid Username or Password");
    }
    return $result;
}


function save($id, $status)
{
    return $status;
}

function cfilter($data)
{
    return $data;
}

function search($sdc, $exp, $loc)
{
    $companies = array(
        array(
            "id" => 1,
            "title" => " JavaScript Developer",
            "category" => "Web Programming",
            "rating" => 4.25,
            "reviews" => 329,
            "image" => "hp.png",
            "exp" => "5 - 10 Years",
            "package" => "1-3 Lakhs",
            "location" => "Amravati",
            "desc" => "Requirements: Bachelors degree in Computer Science, Software Engineering, or relat",
            "skills" => "Javascript | TypeScript |RESTful API | CSS | Git | UI | Redux | HTML"
        ),
        array(
            "id" => 2,
            "title" => "Mobile App Developer - Java",
            "category" => "Mobile Programming",
            "rating" => 5.0,
            "reviews" => 429,
            "image" => "lg.png",
            "exp" => "1 - 5 Years",
            "package" => "2-5 Lakhs",
            "location" => "Mumbai",
            "desc" => "Mobile App Developer needed to design native android apps",
            "skills" => "Java | XML |RESTful API | Git | UI  | HTML"
        )
    );

    return $companies;
}

function register($pname, $password, $age, $city, $gender)
{
    if ($gender == "male") {
        $result = array("result" => 1, "message" => "Registration Successfull");
        return $result;
    } else {
        $result = array("result" => 0, "message" => "Registration Failed");
        return $result;
    }
}

function getProfile()
{
    $pinfo = array(
        "name" => "Ravi",
        "username" => "ravi",
        "phone" => "9595210063",
        "gender" => "male",
        "age" => 23,
        "email" => "ravi@gmail.com"
    );
    return $pinfo;
}

function getSavedJobs()
{
    $jobj = array(
        "companies" => array(
            array(
                "id" => 1,
                "title" => "React.js Developer - HTML/ CSS/ JavaScript",
                "category" => "Web Programming",
                "rating" => 4.25,
                "reviews" => 329,
                "image" => "hp.png",
                "exp" => "5 - 10 Years",
                "package" => "1-3 Lakhs",
                "location" => "Amravati",
                "desc" => "Requirements: Bachelors degree in Computer Science, Software Engineering, or relat",
                "skills" => "Javascript | TypeScript |RESTful API | CSS | Git | UI | Redux | HTML"
            ),
            array(
                "id" => 2,
                "title" => "Mobile App Developer - Java",
                "category" => "Mobile Programming",
                "rating" => 5.0,
                "reviews" => 429,
                "image" => "lg.png",
                "exp" => "1 - 5 Years",
                "package" => "2-5 Lakhs",
                "location" => "Mumbai",
                "desc" => "Mobile App Developer needed to design native android apps",
                "skills" => "Java | XML |RESTful API | Git | UI  | HTML"
            )
        ),
        "pinfo" => array(
            "username" => "ravi",
            "phone" => "9595210063"
        )
    );
    return $jobj;
}

function register($pname, $password, $age, $city, $gender)
{
    global $conn;
    $stmt=$conn->prepare("INSERT INTO users( name, password, age, gender, city) VALUES (?,?,?,?,?)");
    if($stmt)
    {
        $stmt->bind_param("ssiss",$pname,$password,$age,$gender,$city);
        if($stmt->execute())
        {        
            $result = array("result" => 1, "message" => "Registration Successfull");
            return $result;    
        }else{
            $result = array("result" => 0, "message" => "Registration Failed");
            return $result;  
        }

    }else{
        echo $conn->connect_error;
    }

}

function getjobinfo($id){
    global $conn;
    $stmt=$conn->prepare("SELECT * FROM jobs INNER JOIN companies ON jobs.company=companies.id INNER JOIN categories ON jobs.category=categories.id WHERE jobs.id=?;");
    if($stmt)
    {
        $stmt->bind_param("i",$id);
        if($stmt->execute())
        {
             $result= $stmt->get_result();
             $companies=array();
             $row = $result->fetch_assoc();
             
             
             return $row;

        }else{
           echo $conn->connect_error;
        }

    }else{
        echo $conn->connect_error;
    }
}

function getbenefits($id){
    global $conn;
    $stmt=$conn->prepare("SELECT * FROM `benifits` WHERE jobid=?;");
    if($stmt)
    {
        $stmt->bind_param("i",$id);
        if($stmt->execute())
        {
             $result= $stmt->get_result();
             $benefits = array();
             while($row=$result->fetch_assoc())
             {
                array_push($benefits,$row);
             }
             
             return $benefits;

        }else{
           echo $conn->connect_error;
        }

    }else{
        echo $conn->connect_error;
    }
}





    function getCompanyDesc($id)
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM jobdesc INNER JOIN jobtitles ON jobdesc.title=jobtitles.id WHERE jobdesc.jobid=?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $companies = [];

            // Process each row in the result
            while ($row = $result->fetch_assoc()) {
                $title = $row['title'];
                $description = $row['description'];

                // Check if the title already exists in the $companies array
                $found = false;
                foreach ($companies as &$entry) {
                    if ($entry['title'] === $title) {
                        // Add the description to the existing title entry
                        $entry['desc'][] = $description;
                        $found = true;
                        break;
                    }
                }

                // If the title does not exist, create a new entry
                if (!$found) {
                    $companies[] = [
                        "title" => $title,
                        "desc" => [$description]
                    ];
                }
            }
                return $companies;
            
        } else {
            echo $conn->error;
        }
        
    } else {
        echo $conn->error;
    }
}

function getCompanyInfo($id)
{
    $jobinfo=getjobinfo($id);
    $benefits=getbenefits($id);
    $jobdesc=getCompanyDesc($id);

    $jobDetails = array(
        "jobInfo" => $jobinfo,
        "benifits"=>$benefits,
        "jobdesc"=>$jobdesc
        
    );
    return $jobDetails;
}

function getCompaniesDesc($id)
{
    global $conn;
    $stmt=$conn->prepare("SELECT jobs.id,jobs.title, jobs.exp,jobs.package,jobs.location,jobs.info, jobs.skills,
     companies.image, companies.rating, companies.review,categories.category FROM `jobs` INNER JOIN companies ON jobs.company=companies.id
      INNER JOIN categories ON companies.category=categories.id WHERE categories.id=?;");
    if($stmt)
    {
        $stmt->bind_param("i",$id);
        if($stmt->execute())
        {
             $result= $stmt->get_result();
             $companies = array();
             while($row=$result->fetch_assoc())
             {
                array_push($companies,$row);
             }
             
             return $companies;

        }else{
           echo $conn->connect_error;
        }

    }else{
        echo $conn->connect_error;
    }
    return $companies;
}







function getButtons()
{
    global $conn;
    $stmt=$conn->prepare("SELECT * FROM `categories`");
    if($stmt)
    {
        if($stmt->execute())
        {
             $result= $stmt->get_result();
             $btns = array();
             while($row=$result->fetch_assoc())
             {
                array_push($btns,$row);
             }
             $buttonsObj = array("buttons" => $btns);
             return $buttonsObj;

        }else{
           echo $conn->connect_error;
        }

    }else{
        echo $conn->connect_error;
    }
  
    
}

function getCompanies()
{

    global $conn;
    $stmt=$conn->prepare("SELECT * FROM `companies`");
    if($stmt)
    {
        if($stmt->execute())
        {
             $result= $stmt->get_result();
             $companies = array();
             while($row=$result->fetch_assoc())
             {
                array_push($companies,$row);
             }
             $companiesObj = array("companies" => $companies);
             return $companiesObj;

        }else{
           echo $conn->connect_error;
        }

    }else{
        echo $conn->connect_error;
    }

    
}

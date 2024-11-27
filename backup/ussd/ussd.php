<?php
header('Content-type: text/plain');

// Read POST variables with safety checks to prevent undefined index errors
$sessionId = $_POST['sessionId'] ?? '';
$networkCode = $_POST['networkCode'] ?? '';
$serviceCode = $_POST['serviceCode'] ?? '';
$phoneNumber = ltrim($_POST['phoneNumber'] ?? '');
$text = $_POST['text'] ?? '';

// Initialize variables
$response = ""; // Prevent undefined variable errors
$textArray = []; // Set $textArray to empty by default

// Function to handle the main menu display
function displayMainMenu()
{
    return "CON Welcome to Sabatia Eye Hospital: \n1. Patients \n2. Training \n3. Partnerships \n4. Staff\n5. Contact Us";
}

// Function to handle the main menu display
function displayHomeMenu()
{
    $text = '';
    $textArray = [];
    return "CON Welcome to Sabatia Eye Hospital:\n1. Patients \n2. Training \n3. Partnerships \n4. Staff\n5. Contact Us";
}

// Function to handle Patients sub-menu
function displayPatientsMenu()
{
    return "CON Patient Services: \n1. Book Appointment\n2. Insurance\n3. Our Clinics\n4. Feedback\n5. Back to Main Menu";
}

// Function to handle Staff sub-menu
function displayStaffMenu()
{
    return "CON Staff Portal: \n1. Apply Leave\n2. Leave Balance\n3. Payslips\n4. Contact HR\n5. Back to Main Menu";
}

// Additional sub-menu for "Book Appointment" under Patients
function displayBookAppointmentMenu()
{
    return "CON Book Appointment Services: \n1. General Clinic\n2. Vitreo Retinal\n3. Paediatric Clinic\n4. Low Vision Clinic\n5. Back to Patient Menu \n6. Main Menu";
}

// Additional sub-menu for "Leave Balance" under Staff
function displayLeaveBalanceMenu()
{
    return "CON Leave Balance Options: \n1. Check Leave Balance\n2. View Leave History\n3. Apply for Leave\n4. Back to Staff Menu";
}

// Display clinics contacts
function displayClinics()
{
    return "CON Our Contacts: \n1. Sabatia - Main\n2. Eldoret Clinic\n3. Kisumu Clinic\n4. Email Us\n5. Main Menu";
}

// Check if the text is empty to show the main menu
if (empty($text)) {
    $response = displayMainMenu();
    // code...
    $inslog = "INSERT INTO applogs(phone,session,topic,verse,referrer,ip_address,date_created) VALUES ('$phoneNumber','$sessionId',NULL,NULL,'$referrer','$ip','$idate')";
    $inslog = mysqli_query($con, $inslog);
} else {
    // Split the text to track the navigation state
    $textArray = explode('*', $text);
    $level = count($textArray);

    // Handle main menu navigation
    switch ($textArray[0]) {
        case "1": // Patients Menu
            if ($level == 1) {
                $response = displayPatientsMenu(); // Show Patients sub-menu
            } elseif ($level == 2) {
                switch ($textArray[1]) {
                    case "1":
                        $response = displayBookAppointmentMenu(); // Show Book Appointment sub-menu
                        break;
                    case "2":
                        $response = "END Our accepted insurance plans include: NHIF, CIC, and Medical Administrators. Thank you!";
                        break;
                    case "3":
                        $response = "END You have selected 'Our Clinics'. Visit our clinics located at: Vihiga, Kisumu and Eldoret. Thank you!";
                        break;
                    case "4":
                        $response = "END You have selected 'Feedback'. We are sending you an SMS shortly. Thank you!";
                        break;
                    case "5":
                        // Reset text and textArray to return to Main Menu
                        $text = '';
                        $textArray = [];
                        $response = displayHomeMenu();
                        break;
                    default:
                        $response = "END Invalid input. Please try again. Thank you!";
                }
            } elseif ($level == 3) {
                if ($textArray[1] == "1") { // Sub-menu for Book Appointment
                    switch ($textArray[2]) {
                        case "1":
                            $response = "END You have selected 'General Clinic'. You will receive an SMS shortly. Thank you!";
                            break;
                        case "2":
                            $response = "END You have selected 'Vitreo Retinal Clinic'. You will receive an SMS shortly. Thank you!";
                            break;
                        case "3":
                            $response = "END You have selected 'Paediatric Clinic'. You will receive an SMS shortly. Thank you!";
                            break;
                        case "4":
                            $response = "END You have selected 'Low Vision Clinic'. You will receive an SMS shortly. Thank you!";
                            break;
                        case "5":
                            // Reset textArray to go back to Patients Menu
                            $textArray = ["1"];
                            $response = displayPatientsMenu();
                            break;
                        case "6":
                            // Reset text and textArray to return to Main Menu
                            $text = '';
                            $textArray = [];
                            $response = displayMainMenu();
                            break;
                        default:
                            $response = "END Invalid input. Please try again. Thank you!";
                    }
                }
            }
            break;

        case "2": // Training Menu
            $response = "CON Training Services: \n1. Apply for OSUC\n2. Bsc COCs \n3. B.Optom\n4. Other";
            break;

        case "3": // Partnerships Menu
            $response = "CON Partner Relations: \n1. Prospectus\n2. Donate";
            break;

        case "4": // Staff Menu
            if ($level == 1) {
                $response = displayStaffMenu(); // Show Staff sub-menu
            } elseif ($level == 2) {
                switch ($textArray[1]) {
                    case "1":
                        $response = "END You have selected 'Apply Leave'. Please submit your leave application through the staff portal. Thank you!";
                        break;
                    case "2":
                        $response = displayLeaveBalanceMenu(); // Show Leave Balance sub-menu
                        break;
                    case "3":
                        $response = "END You have selected 'Payslips'. Payslips are accessible through the staff portal. Thank you!";
                        break;
                    case "4":
                        $response = "END Email: annette.mwangale@sabatiaeyehospital.org";
                        break;
                    case "5":
                        // Reset text and textArray to return to Main Menu
                        $text = '';
                        $textArray = [];
                        $response = displayMainMenu();
                        break;
                    default:
                        $response = "END Invalid input. Please try again. Thank you!";
                }
            }
            break;

        case "5": // Contact Us
            if ($level == 1) {
                $response = displayClinics(); // Show Patients sub-menu
            } elseif ($level == 2) {
                switch ($textArray[1]) {
                    case "1":
                        $response = "END Sabatia Eye Hospital (Main) - 0723 721 316. Thank you!";
                        break;
                    case "2":
                        $response = "END Sabatia Eye Hospital (Eldoret) - 0707 650 804. Thank you!";
                        break;
                    case "3":
                        $response = "END Sabatia Eye Hospital (Kisumu) - 0776 169 926. Thank you!";
                        break;
                    case "4":
                        $response = "END Email us: info@sabatiaeyehospital.org. Thank you!";
                        break;
                    case "5":
                        // Reset text and textArray to return to Main Menu
                        $text = '';
                        $textArray = [];
                        $response = displayMainMenu();
                        break;
                    default:
                        $response = "END Invalid input. Please try again. Thank you!";
                }
            }
            break;

        default:
            $response = "END Invalid input. Please try again. Thank you!";
            break;
    }
}

// Trim the response to remove any leading/trailing whitespace
echo trim($response);

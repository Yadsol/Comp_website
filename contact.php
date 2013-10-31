<?php
//+----------------------------------------------------------------+
//| CONTACT.PHP
//+----------------------------------------------------------------+

session_start();
$response=array();

//+----------------------------------------------------------------+
//| email settings
//+----------------------------------------------------------------+

$to = "your@email.com"; /* you email address */
$subject ="Contact form message"; /* email subject */
$message ="You received a mail via your website contact form\n\n"; /* email messege prefix */



//+----------------------------------------------------------------+
//| post data validation
//+----------------------------------------------------------------+

if ($_POST) {
    
    if($_POST['form_type'] === 'quote') {
        $_SESSION['form_type'] = 'quote';
    } else {
        $_SESSION['form_type'] = 'contact';
    }
    
    /* clean input & escape the special chars */
    foreach($_POST as $key=>$value) {
        if(ini_get('magic_quotes_gpc')) { $_POST[$key]=stripslashes($_POST[$key]); }
        $_POST[$key]=htmlspecialchars(strip_tags(trim($_POST[$key])), ENT_QUOTES);
    }
    
    /* check name */
    if (!strlen($_POST['name'])) {
        $response['message']['name']="Field <b>Name</b> is required.";
    }
    /* check email */
    if (!strlen($_POST['email'])) {
        $response['message']['email']="Field <b>Email</b> is required.";
    } elseif (!preg_match("/^[\w-]+(\.[\w-]+)*@([0-9a-z][0-9a-z-]*[0-9a-z]\.)+([a-z]{2,4})$/i", $_POST['email'])) {
        $response['message']['email']="Invalid e-mail address."; 
    }
    /* check website (if given) */
    if (strlen($_POST['website']) && !filter_var($_POST['website'], FILTER_VALIDATE_URL)) {
        $response['message']['website']="Invalid <b>Website</b> URL.";
    }
    
              
    
    // additional conditions if sending a quote
    if( $_POST['form_type'] === 'quote' ) {
        // phone
        if (!strlen($_POST['phone'])) {
            $response['message']['phone']="Field <b>Phone</b> is required.";
        }
        // project
        if (!strlen($_POST['project'])) {
            $response['message']['project']="Field <b>Project</b> is required.";
        }
        
        // service
        if ($_POST['serviceRequired'] == '-1') {
            $response['message']['serviceRequired']="Select a <b>Service</b>.";
        }
    }
    
    
    /* check message */
    if (!strlen($_POST['message'])) {
        $response['message']['message']="Field <b>Message</b> is required.";
    } 
     
    //* check captcha */
    if (!strlen($_POST['captcha'])) {
        $response['message']['captcha']="Field <b>Captcha</b> is required.";
    } elseif ($_POST['captcha']!=$_SESSION['captcha']) {
        $response['message']['captcha']="Invalid captcha.";  
    }    
    
    /* if no error */
    if (!isset($response['message'])) {
         $response['result']='success'; 
    } else {
         $response['result']='error';
    }
        
}
    

//+----------------------------------------------------------------+
//| send the email
//+----------------------------------------------------------------+

if (@$response['result']) {
    if ($response['result']=='success') {
        
        /* build the email message body */
        $message.= 'Sender name: '.$_POST['name']."\n";
        $message.= 'Sender email: '.$_POST['email']."\n";
        $message.= strlen($_POST['website']) ? 'Sender website: '.$_POST['website']."\n" : "Sender website: -\n";
        
        // if sending quote additional fields
        if( $_SESSION['form_type'] === 'quote' ) {
            $message.= 'Sender phone: '.$_POST['phone']."\n";
            $message.= 'Project name: '.$_POST['project']."\n";
            $message.= 'Sender requires service: '.$_POST['serviceRequired']."\n";
            $message.= 'Budget: '.$_POST['budget']."\n";
        }
            
        
        $message.= "\nMessage: \n".$_POST['message'];
        
        /* send the mail */
        if(mail($to, $subject,$message)){
            $response['message']['mail_sent']='Your <b>Message</b> has been sent successfully.';
        } else{
            $response['result']='error';
            $response['message']['mail_sent']='Something went wrong, please try again later.';
        }
    }
    /* if ajax request */
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') { 
        print json_encode($response);
        exit;
    } 
    /* if reqular http request */
    else {
        $_SESSION['reponse']=$response;
        $_SESSION['postdata']=$_POST;
        header('location: '.$_SERVER['PHP_SELF']); 
        exit;
    }
}

//+----------------------------------------------------------------+
//| functions
//+----------------------------------------------------------------+

function check_the_field( $name ) {
    return @($_SESSION['reponse']['result']=='error' && ( isset($_SESSION['reponse']['message'][$name]) || $name==='captcha' ));
}
function error_class( $name ) {
    if ( check_the_field($name) ) {
        echo ' error';
    }
}
function field_val( $name ) {
    if ( ! check_the_field( $name )) {
        $val = @$_SESSION['postdata'][$name];
        echo ' value="' . $val . '" ';
    }
}
function attr_checked( $name, $value, $default = false) {
    $val = @$_SESSION['postdata'][$name];
    if( $val == $value || ( ( empty($_SESSION['postdata']) || $_SESSION['form_type'] != 'quote' ) && $default ) ) {
        echo ' checked';
    }
}
function attr_selected( $name, $value, $default = false) {
    $val = @$_SESSION['postdata'][$name];
    if( $val == $value || ( ( empty($_SESSION['postdata']) || $_SESSION['form_type'] != 'quote' ) && $default ) ) {
        echo ' selected';
    }
}


//+----------------------------------------------------------------+
//| create session data
//+----------------------------------------------------------------+

$_SESSION['no1'] = rand(1,10);  /* first number */
$_SESSION['no2'] = rand(1,10);  /* second number */
$_SESSION['captcha'] = $_SESSION['no1']+$_SESSION['no2'];   /* captcha data */
if( empty( $_SESSION['form_type'] ) ) {
    $_SESSION['form_type'] = 'contact';
}
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
    <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title>Contact us</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- Le styles -->
        <link href="stylesheets/bootstrap.css" rel="stylesheet">
        <link href="stylesheets/responsive.css" rel="stylesheet">
        <link href="js/rs-plugin/css/settings.css" rel="stylesheet">
        <link href="stylesheets/red.css" rel="stylesheet">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <!-- Fav and touch icons -->
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/apple-touch-icon/114x114.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/apple-touch-icon/114x114.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/apple-touch-icon/72x72.png">
        <link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon/57x57.png">
        <link rel="shortcut icon" href="favicon.ico">
    </head>

    <body>

        

        <div class="boxed-container">

            <div class="navbar navbar-inverse navbar-fixed-top">
                <div class="navbar-head">
                    <?php include_once 'header.php';?>
            </div>

            <div class="fullwidthbanner-subpage-container google-map">

                <div class="parallax-slider">
                	<div id="gmap"></div>
                	
                	<div class="container">
                	    <div class="slide slide-map">
                	        <h1>Contact</h1>
                	        <div class="clearfix"></div>
                	        <h2>our slogan for client</h2>
                	        <div class="clearfix"></div>
                	        <h2>some content</h2>
                	    </div>
                	</div>
                </div>

            </div>
            <!-- /fullwidthbanner-container -->

            <div class="container content">

                <div class="row no-bottom">
                    <div class="span9">

                        <div class="row">

                            <div class="span9">
                                <div class="page-header arrow-grey">
                                    <h2 id="moveToForm">Get in touch!</h2>
                                </div>
                            </div>

                            <div class="span9">
                                <p class="push-down-30">
                                    Reign soft is a solution provider for various systems in Information Technology. We in our development process follow legacy systems. Our operation towards IT development was made in India and offered consulting and development services in software and hardware design to multiple clients.
                                </p>
                            </div>

                        </div>

                        <div class="row">
                            
                            <div class="span9">
                                     <?php
                                if (isset($_SESSION['reponse']) && $_SESSION['reponse']['result']=='success') { ?>
                                <p>
                                    <div class="alert alert-success">
                                        <button class="close smooth-close-parent" type="button">
                                            <i class="icon-close-dark"></i>
                                        </button>
                                        <?php echo $_SESSION['reponse']['message']['mail_sent']; ?>
                                    </div>
                                </p>
                                <?php
                                    unset($_SESSION['reponse']);
                                    unset($_SESSION['postdata']);
                                ?>
                                <?php } elseif (@$_SESSION['reponse']['result']=='error' ) { ?>
                                    <?php foreach( $_SESSION['reponse']['message'] as $msg ) { ?>
                                        <div class="alert alert-error">
                                            <button class="close smooth-close-parent" type="button">
                                                <i class="icon-close-dark"></i>
                                            </button>
                                            <?php echo $msg; ?>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                                </div>
                            
                            <div class="span9 contact-form">

                                <div class="page-header arrow-grey">
                                    <h2>Contact and Quote form</h2>
                                </div>

                                

                                <div class="tab-content mobile-spacing-10" id="contactFormsContainer">
                                    <div class="inner-slide-pane"<?php echo $_SESSION['form_type'] === 'quote' ? ' style="margin-left: -100%;"' : ''; ?>>
                                        <div class="slide-pane">
                                            <form method="post" action="contact.php#moveToForm" novalidate>
                                                <input type="hidden" name="form_type" value="contact" />
                                                <div class="controls controls-row row">
                                                    <div class="span3 control-group<?php error_class('name'); ?>">
                                                        <label for="name" class="control-label">Name <span class="green">*</span></label>
                                                        <input id="name" name="name" type="text" class="span3" <?php field_val('name'); ?>>
                                                    </div>
                                                    <div class="span3 control-group<?php error_class('email'); ?>">
                                                        <label for="email" class="control-label">E-mail <span class="grey">(will not be published)</span> <span class="green">*</span></label>
                                                        <input id="email" name="email" type="text"" class="span3" <?php field_val('email'); ?>>
                                                    </div>
                                                    <div class="span3 control-group<?php error_class('website'); ?>">
                                                        <label for="website" class="control-label">Website <span class="grey">(e.g. http://website.com)</span></label>
                                                        <input id="website" name="website" type="text" class="span3" <?php field_val('website'); ?>>
                                                    </div>
                                                </div>
                                                <div class="controls control-group<?php error_class('message'); ?>">
                                                    <label for="message" class="control-label">Your Message <span class="green">*</span></label>
                                                    <textarea id="message" name="message" class="span9" rows="8"><?php echo @$_SESSION['postdata']['message']; ?></textarea>
                                                </div>

                                                <div class="controls">
                                                    <button id="contact-submit-2" type="submit" class="btn btn-green pull-left move-9">
                                                        Send E-mail
                                                    </button>
                                                    <div class="pull-right control-group<?php error_class('captcha'); ?>">
                                                        <span class="are-you-label control-label">Are you human? <?php echo $_SESSION['no1']; ?> + <?php echo $_SESSION['no2']; ?> = </span>
                                                        <input name="captcha" type="text" class="input-are-you-human">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="slide-pane">
                                            <form method="post" action="contact.php#moveToForm" novalidate>
                                                <input type="hidden" name="form_type" value="quote" />
                                                <div class="controls controls-row row">
                                                    <div class="span3 control-group<?php error_class('name'); ?>">
                                                        <label for="name2">Name <span class="green">*</span></label>
                                                        <input id="name2" name="name" type="text" class="span3" <?php field_val('name'); ?>>
                                                    </div>
                                                    <div class="span3 control-group<?php error_class('email'); ?>">
                                                        <label for="email2">E-mail <span class="grey">(will not be published)</span> <span class="green">*</span></label>
                                                        <input id="email2" name="email" type="text"" class="span3" <?php field_val('email'); ?>>
                                                    </div>
                                                    <div class="span3 control-group<?php error_class('website'); ?>">
                                                        <label for="website2">Website <span class="grey">(e.g. http://website.com)</span></label>
                                                        <input id="website2" name="website" type="text" class="span3" <?php field_val('website'); ?>>
                                                    </div>
                                                </div>
                                                <div class="controls controls-row row">
                                                    <div class="span3 control-group<?php error_class('phone'); ?>">
                                                        <label for="phone">Phone <span class="green">*</span></label>
                                                        <input id="phone" name="phone" type="text" class="span3" <?php field_val('phone'); ?>>
                                                    </div>
                                                    <div class="span3 control-group<?php error_class('project'); ?>">
                                                        <label for="projectName">Project Name <span class="green">*</span></label>
                                                        <input id="projectName" name="project" type="text" class="span3" <?php field_val('project'); ?>>
                                                    </div>
                                                    <div class="span3 control-group<?php error_class('serviceRequired'); ?>">
                                                        <label for="selectService">Require Service <span class="green">*</span></label>
                                                        <select title='Select a Service...' class="input-block-level" id="selectService" name="serviceRequired">
                                                            <option value="-1"<?php attr_selected('serviceRequired', -1, true); ?>>Select a service ...</option>
                                                            <option value="Service One"<?php attr_selected('serviceRequired', 'Service One'); ?>>Service One</option>
                                                            <option value="Service Two"<?php attr_selected('serviceRequired', 'Service Two'); ?>>Service Two</option>
                                                            <option value="Service Three"<?php attr_selected('serviceRequired', 'Service Three'); ?>>Service Three</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="controls controls-row row">
                                                    <div class="span9 require-budget">
                                                        Require Budget <span class="green">*</span>
                                                        <br />
                                                        <label class="radio inline">
                                                            <input type="radio" value="500" name="budget"<?php attr_checked('budget', 500, true); ?>>
                                                            &lt; $500 </label>
                                                        <label class="radio inline">
                                                            <input type="radio" value="1000" name="budget"<?php attr_checked('budget', 1000); ?>>
                                                            &lt; $1000 </label>
                                                        <label class="radio inline">
                                                            <input type="radio" value="1500" name="budget"<?php attr_checked('budget', 1500); ?>>
                                                            &lt; $1500 </label>
                                                        <label class="radio inline">
                                                            <input type="radio" value="2000" name="budget"<?php attr_checked('budget', 2000); ?>>
                                                            $2000+ </label>
                                                    </div>
                                                </div>
                                                <div class="controls control-group<?php error_class('message'); ?>">
                                                    <label for="message2">Your Message <span class="green">*</span></label>
                                                    <textarea id="message2" name="message" class="span9" rows="8"><?php echo @$_SESSION['postdata']['message']; ?></textarea>
                                                </div>

                                                <div class="controls">
                                                    <button id="contact-submit-1" type="submit" class="btn btn-green pull-left move-9">
                                                        Send E-mail
                                                    </button>
                                                    <div class="pull-right control-group<?php error_class('captcha'); ?>">
                                                        <span class="are-you-label control-label">Are you human? <?php echo $_SESSION['no1']; ?> + <?php echo $_SESSION['no2']; ?> = </span>
                                                        <input name="captcha" type="text" class="input-are-you-human">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    unset($_SESSION['form_type']);
                                    unset($_SESSION['reponse']);
                                    unset($_SESSION['postdata']);
                                ?>
                            </div>

                        </div>
                        <!-- end row -->

                    </div>

                    <!-- Right Column -->

                    <div class="span3 right-column">

                        <div class="row">

                            <div class="span3">
                                <div class="page-header arrow-grey">
                                    <h2>Address Info</h2>
                                </div>
                            </div>

                            <div class="span3">

                                <address>
                                    43,1 st floor L3, 7th Cross Rd, <br>Maruthi Nagar,
                                    <br>
                                    Bangalore, KA 560068, India 
                                </address>

                                <address>
                                    Tel: +91-422-3301277
                                    <br>
                                    Mob: +91-7667328485
                                    <br>
                                    <a href="mailto:contact@reignsoft.in">contact@reignsoft.in</a>
                                </address>

                            </div>

                        </div>
                        <!-- end row -->


                    </div>

                    <!-- end Right Column -->

                </div>
                <!-- end row -->

            </div>
            <!-- /container -->

            <?php include_once 'footer.php';?>

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery.js"></script>
<script>
 $(function() {
	   $('#contact').addClass('active mobile-active');
	   $('body').addClass('boxed');
 });
</script>
<script src="js/bootstrap.min.js"></script>

<!--  ==========  -->
<!--  = Isotope JS =  -->
<!--  ==========  -->
<script src="js/isotope/jquery.isotope.min.js" type="text/javascript"></script>

<!--  ==========  -->
<!--  = Slider Revolution =  -->
<!--  ==========  -->
<script src="js/rs-plugin/pluginsources/jquery.themepunch.plugins.min.js" type="text/javascript"></script>
<script src="js/rs-plugin/js/jquery.themepunch.revolution.min.js" type="text/javascript"></script>

<!--  ==========  -->
<!--  = Media Element and mp3 player =  -->
<!--  ==========  -->
<script src="js/mediaelementjs-skin/lib/mediaelement.js" type="text/javascript"></script>
<script src="js/mediaelementjs-skin/lib/mediaelementplayer.js" type="text/javascript"></script>

<!--  ==========  -->
<!--  = Carousel CarouFredSel =  -->
<!--  ==========  -->
<script src="js/carouFredSel-6.2.1/jquery.carouFredSel-6.2.1-packed.js" type="text/javascript"></script>

<!--  ==========  -->
<!--  = prettyPhoto lightbox =  -->
<!--  ==========  -->
<script src="js/prettyPhoto/js/jquery.prettyPhoto.js" type="text/javascript"></script>

<!--  ==========  -->
<!--  = Style Swithcer =  -->
<!--  ==========  -->
<script src="js/styleswitcher/jquery_cookie.js" type="text/javascript"></script>
<script src="js/styleswitcher/styleswitcher.js" type="text/javascript"></script>

<!--  ==========  -->
<!--  = Flickr Feed =  -->
<!--  ==========  -->
<script src="js/jflickrfeed/jflickrfeed.min.js" type="text/javascript"></script>


<!--  ==========  -->
<!--  = Google Maps API =  -->
<!--  ==========  -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script src="js/gomap.min.js" type="text/javascript"></script>

<!--  ==========  -->
<!--  = Custom JS =  -->
<!--  ==========  -->
<script src="js/custom.js" type="text/javascript" charset="utf-8"></script>

    </body>
</html>

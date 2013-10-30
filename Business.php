<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js">
    <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <title></title>
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
		 <div id="gw-switcher">
            <div class="gw-switcher-body">
                <div class="gw-switcher-row gw-switcher-header">
                    <h1>Style Selector</h1>
                </div>
                <div class="gw-switcher-tab">
                    <a href="#"></a>
                </div>
                <div class="gw-switcher-row">
                    <a href="#" class="go-switcher-opt-boxed"><span></span>Wide / Boxed</a>
                </div>
                <div class="gw-switcher-row">
                    <a href="#" class="go-switcher-opt-sticky go-switcher-opt-checked"><span></span>Static / Sticky</a>
                </div>
            </div>
        </div>

		<div class="navbar navbar-inverse navbar-fixed-top">
		
                <div class="navbar-head">
                    <?php include_once 'header.php';?>
            </div>

            <!-- /fullwidthbanner-container -->

            <div class="container content page">

                <div class="row mobile-spacing-5">
				 
                  <div class="span3" style="line-height:30px;margin-right:0px;border-right:1px solid red; width:200px">
					
					<h3  style="color:red">SERVICES</h3>
			
					<a  style="color:black"href="retail-management.php">Retail Management System</a><br>
						
					<a style="color:black" href="Supply-chain.php">Supply Chain Planne</a><br>
							
					<a style="color:black" href ="inventary-management.php">Inventory Management System</a><br>
						
					<a  style="color:black" href="ERP.php">Enterprise Resource Planning</a><br>
						
					<a  style="color:black" href="order-management.php">Order Management system</a><br>
							
					<a  style="color:black" href="demand-palnning.php">Demand Planner</a><br>
				    </div>
                    <div class="span9">
					<div class="span9" style="margin:0px; height:60px;">
							   <div class="thumbnail" style="border-top:0px;" >
                                            <div class="caption-border-bottom">
                                                <div class="caption caption-arrow">
                                                <h3><a href="#">BUSINESS INTELLIGENCE</a></h3>
                                            </div></div></div></div>
					
					<div class="span4 pull-right">
<img src="images/services/b1.jpg"></img>
</div>
				

                            <p>The business intelligent data warehouse for the manufacturing enterprise. Helping you manage your business, analytically. Reignsoft has combined manufacturing industry and BI design experience to create pre-built data warehouse to accelerate data warehouse implementations. Our consultants are experienced in creating business views and OLAP cubes/ data marts that work off the back-office OLTP systems. Our scalable solution architecture separates the transaction systems from the reporting and analytical work, thus ensuring that reports and OLAP do not affect the performance of the transaction systems or the load on the main servers</p>

<p>Reignsoft’s Business Intelligence services cover the entire analytical information architecture which includes data acquisition, data warehousing and business analytic tools. We have a complete, comprehensive set of service offerings which can help you evaluate, assess, deploy and maintain BI applications:</p>
<br>
<p>
<img src="images/c-arrow.png" />	BI/DW strategy and roadmap definition<br>
<img src="images/c-arrow.png" />	Setting up of BI Competency Centre<br>
<img src="images/c-arrow.png" />	BI/DW Audits and Health Checks<br>
<img src="images/c-arrow.png" />	BI/DW implementation, upgrade and support<br>
<img src="images/c-arrow.png" />	Data Governance - Data cleansing, integration and quality<br>
<img src="images/c-arrow.png" />	Rapid dashboard implementation frameworks<br>
<img src="images/c-arrow.png" />	Enablement of mobile BI<br>

<p>Our ease of use application enables higher productivity in reporting, and reduces the workload for the IT departments. Also Reports can be automatically scheduled and emailed; this enables users to get the information they want in actionable time.</p>
<br>
<h4 class="muted"> Key Features</h4>
<br>
<img src="images/c-arrow.png" />	 Provides a business layer which is easy to understand<br>
<img src="images/c-arrow.png" />	Encapsulate data structure and its complexities from users<br>
<img src="images/c-arrow.png" />	Drag-and-drop reporting features, even business users can create their own reports<br>
<img src="images/c-arrow.png" />	Increased productivity for report creation and Low maintenance report changes<br>

<br>With our proven methodologies, deep expertise, and industry specialization, we can deliver actionable and measurable business results that inform decision-making, optimize IT efficiency, and improve business performance.

                        </div>
</div></div></div>
                  
            <!-- /container -->
 <?php include_once 'footer.php';?>
</div>
<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="js/jquery.js"></script>
<script>
 $(function() {
	   $('#aboutus').addClass('active mobile-active');
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
<!--  = Custom JS =  -->
<!--  ==========  -->
<script src="js/custom.js" type="text/javascript" charset="utf-8"></script>

    </body>
</html>

<nav class="navbar navbar-inverse navbar-fixed-top" >
	  <div class="navbar-inner">
        <div class="container-fluid">
		        <div class="row clearfix">
			          <div class="col-md-5 column"></div>
			          <div class="col-md-7 column">
			              <div class="navbar-header centering" role="navigation">
			                  <br>
			                  <a style="font-size:40px;" class="navbar-brand" href="#"><?php if($title=="Home") echo "&nbsp&nbsp&nbsp&nbsp"; echo $title; ?></a>
			              </div>
			              <div  class="text-right">
			                  <br>
				                <!-- The action here should be changed or added to controller -->
				                <form class="form-inline m-0" action="hyper_search">
					                  <input class="form-control mr-2" type="text" name="name" placeholder="Search">
					                  <button class="btn btn-primary" type="submit">Search</button>
				                </form>
			                  <br>
			              </div>
			          </div>
			          <div class="col-md-2 column"></div>
		        </div>
		        <!-- On click event should be added to enable the links in the breadcrumd -->
		        <?php if($title!="Home"){ ?>
		            <div class="row clearfix">
			              <div class="col-md-12 column">
			                  <ul class="breadcrumb breadcrumb-setting-0">
				                    <li class="breadcrumb-item">
					                      <a href="###" id="breadcrumb-home-link">Home</a>
				                    </li>
				                    <?php if($title=="Result Page") { ?>
				                        <li class="breadcrumb-item active" style="color:#FFFFFF">
					                          Result
				                        </li>
				                    <?php } elseif($title=="Author Page"){ ?>
				                         <li class="breadcrumb-item">
					                           <a href="###" id="breadcrumb-result-link">Result</a>
				                         </li>
				                         <li class="breadcrumb-item active" style="color:#FFFFFF">
					                           Author
				                         </li>
				                    <?php } ?>
			                  </ul>
			              </div>
		            </div>
		        <?php } ?>
	      </div>
	  </div>
</nav><br><br><br><br>

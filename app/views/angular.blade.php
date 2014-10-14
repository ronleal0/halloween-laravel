<?php 
  include(app_path().'/libs/NewPagination.php');
 ?>  

@extends('layout.angularMaster')
@section('content')

    <div class="outerMain">
      <div class="row main">
      <div class="large-12 columns searchbox" >
          <form name="searchform" method="get" onSubmit="return dosearch();">
               <div class="large-7 large-centered columns">
                  <div class="row collapse">
                    <div class="small-10 columns">
                      <input style="margin:0" type="text" name="query" value="" placeholder="Search for Halloween items.." required>
                    </div>
                    <div class="small-2 columns">
                      <input id="searchButton" style="margin:0" type="submit" value="search" class="button postfix">
                    </div>
                  </div>
                </div>
                <div class="large-7 large-centered columns">
                  <div class="large-6 columns">
                    <input type="radio" name="siteSearch" value="/become/q?query=" id="forthis"><label for="forthis">Search this page</label>
                  </div>
                  <div class="large-6 columns">
                    <input type="radio" name="siteSearch" value="http://www.become.com/q?qry=" id="forthat"><label for="forthat">Search Become</label>
                  </div>
                </div>
          </form> 
      </div>
        <div class="large-2 columns sidebar" ng-controller="sideController">
          <dl class="accordion" data-accordion>
            <dd class="accordion-navigation">
              <a href="#panel1" class="accordionTitle">Browse Categories</a>
              <div id="panel1" class="accordionContent active content">
                 <ul>
	                 <li ng-repeat="cats in categories">
	                  <a href="/become/static?cat=@{{cats.parameter}}">@{{ cats.name }}</a>
	                 </li>
               </ul>
              </div>
            </dd>
             <dd class="accordion-navigation">
              <a href="#panel1" class="accordionTitle">Browse Merchants</a>
              <div id="panel1" class="accordionContent active content">
                 <ul>
                   <li ng-repeat="merchant in merchants">
                    <a href="/become/static?mer=@{{merchant.parameter}}">@{{ merchant.name }}</a>
                   </li>
               </ul>
              </div>
            </dd>
          </dl>
        </div>
      <!-- END OF SIDEBAR -->
      <div class="large-10 columns productPart" data-equalizer ng-controller="appController">


              <div class="productbox large-3 columns" data-equalizer-watch ng-repeat="product in products">
              
                <img ng-src="@{{ product.ImageLink }}" >

                <ul>
                  <li class="prodName"><a href="@{{ product.MerchantAddress }}">@{{ product.ProductName }}</a></li>
                  <li class="price">
                  
                    @{{ product.Price }}
                  </li>
                   <li class="seller">@{{ product.Merchant }}</li>
                </ul>
                <a target="_blank" href="@{{ product.MerchantAddress }}" class="secondary button">See it</a>
              </div>
      </div>
      <!-- End of productPart -->
    </div>
    </div>
    @stop
    @section('angular')
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
    @if($merchant != '')<script src="/js/json/{{$merchant}}.jsonp"></script>@endif
		@if($json != '')<script src="/js/json/{{$json}}.jsonp"></script>@endif
		<script src="/js/myangular.js"></script>
    @stop
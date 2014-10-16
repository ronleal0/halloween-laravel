<?php 
//  include(app_path().'/libs/NewPagination.php');
 ?>  

@extends('layout.master')
    @section('angular')
      <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.26/angular.min.js"></script>
      <script src="/js/myangular.js"></script>
    @stop
@section('content')
    <div class="outer">
    <div class="row header">
      <div class="large-12 columns ">
        <h1 class="logo">
          <img src="http://proxy.become.com/resource/portals/become/static/images/us/logo.png" alt="">
          <a href="/become">Halloween</a></h1>
      </div>
    </div>
    </div>
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
              <a href="#panel1" class="accordionTitle">Popular Categories</a>
              <div id="panel1" class="accordionContent active content">
                 <ul>
                   <li ng-repeat="cats in categories">
                    <a href="/become/static?cat=@{{cats.parameter}}">@{{ cats.name }}</a>
                   </li>
               </ul>
              </div>
            </dd>
             <dd class="accordion-navigation">
              <a href="#panel1" class="accordionTitle">Popular Merchants</a>
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
      <div class="large-10 columns productPart" data-equalizer >
          @if($hasResult)
            <?php 
              $page = new NewPagination();
              $pageNumbers = $page->paginate($products, 20);
              $products = $page->fetchResults();
            ?>
            <section class="titleSuggested large-12 column">
                <p>SUGGESTED PRODUCTS</p>
              </section>
            <div id="carouselMain" class="large-12 columns owl-carousel">
              
                @foreach($popularProducts as $popProds)
                  <div class="eachslide">
                    <img class="lazyOwl" data-src="{{ str_replace("/B_","/D_", $popProds->image[0]['source']) }}" alt="">
                  
                    <span class="details">
                      @if($gclid != false)
                      <a target="_blank" href="{{$popProds->offer->url}}&gclid={{ $gclid }}">{{ str_limit($popProds->label, 50) }}</a>
                      @else
                      <a target="_blank" href="{{$popProds->offer->url}}">{{str_limit($popProds->label, 50) }}</a>
                      @endif
                    </span>
                   

                  </div>
                 @endforeach
            </div>
            @foreach($products as $product)
              <div class="productbox large-3 columns" data-equalizer-watch>
                <!-- MODAL -->
                <div data-reveal id="offer{{$product['oid']}}" class="reveal-modal" >
                  <div class="image" >
                    <img src="{{ $product->image[0]['source'] }}" alt="{{$product->label}}">
                    </div>
                    <div class="details">
                      <h2>{{$product->label}}</h2>
                      @if($product->description)
                      <p>{{$product->description}}</p>
                      @endif
                    <ul>

                      <li class="price">${{ $product->offer->price }}</li>
                       <li class="seller"> @if($product['nr-of-merchants'] != 0){{ $product->offer->merchant->label }}@endif</li>
                    </ul>
                    <p>
                      @if($gclid != false)
                      <a target="_blank" href="{{ $product->offer->url }}&gclid={{ $gclid }}" class="secondary button">See Product</a>
                      @else
                      <a target="_blank" href="{{ $product->offer->url }}" class="secondary button">See Product</a>
                      @endif
                    </p>
                  </div>
                  <a class="close-reveal-modal">&#215;</a>
                </div>

               
                <img src="{{ $product->image[0]['source'] }}" >

                <ul>
                  <li class="prodName">
                    @if( $gclid != false)
                    <a target="_blank" href="{{ $product->offer->url }}&gclid={{$gclid}}">{{$product->label}}</a>
                    @else
                    <a target="_blank" href="{{ $product->offer->url }}">{{$product->label}}</a>
                    @endif
                  </li>
                  
                    <p class="pitch">@if($product->offer->pitch){{ $product->offer->pitch }}@endif</p>
                  <li><a href="" data-reveal-id="offer{{$product['oid']}}" class="modal moreinfo">more info</a></li>
                  <li class="price">
                    <span class="before">@if($product->offer->{'price-info'}[0])${{$product->offer->{'price-info'}[0]}}@endif</span> 
                    ${{ $product->offer->price }}
                  </li>
                   <li class="seller"> @if($product['nr-of-merchants'] != 0){{ $product->offer->merchant->label }}@endif</li>
                </ul>
                @if($gclid != false)
                <a target="_blank" href="{{ $product->offer->url }}&gclid={{ $gclid }}" class="secondary button">See it</a>
                @else
                <a target="_blank" href="{{ $product->offer->url }}" class="secondary button">See it</a>
                @endif
              </div>

              @endforeach
            @else
              <div class="large-12">
                <h2 style="text-align: center">Sorry....no results for <u>{{$query}}</u></h2>
              </div>
            @endif
      </div>
      <!-- End of productPart -->
    </div>
    </div>
   <!--  @if($hasResult)
     <div class="row">
         <ul style="display:hidden" class="pagination">
            @foreach($pageNumbers as $num)
           <?php 
          /* if(isset($_GET['page'])){
             $curr = $_GET['page'];
           }else{
             $curr = '';
           }*/
   
            ?>
             @if($isQueryPage)
               <li><a {{($curr == $num) ? 'class="active"' : ''}} href="{{URL::current()}}?query={{$query}}&page={{$num}}"></a></li>
             @else
               <li><a {{($curr == $num) ? 'class="active"' : ''}} href="{{URL::current()}}?page={{$num}}"></a></li>
             @endif
            @endforeach
         </ul>
       </div>
   @endif -->
    @stop

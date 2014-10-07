<?php 
  include(app_path().'/libs/NewPagination.php');
 ?>  

@extends('layout.master')
@section('content')
    <div class="outer">
    <div class="row header">
      <div class="large-12 columns ">
        <h1 class="logo"><a href="/">Halloween</a></h1>
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
       @if($hasResult)
        <div class="large-2 columns sidebar">
          <dl class="accordion" data-accordion>
            <dd class="accordion-navigation">
              <a href="#panel1" class="accordionTitle">Suggested Products</a>
              <div id="panel1" class="accordionContent active content">
                 <ul>
                 @foreach($popularProducts as $popProds)
                 <li>
                  <a target="_blank" href="{{$popProds->offer->url}}">{{$popProds->label}}</a>
                 </li>
                 @endforeach
               </ul>
              </div>
            </dd>
            @foreach($filters as $filter)
              <dd class="accordion-navigation">
              <a href="#{{$filter->label}}" class="accordionTitle">{{$filter->label}}</a>
              <div id="{{$filter->label}}" class="accordionContent content">
                 <ul>
                  @foreach($filter->{'dimension-class'} as $class)
                  <li><a href="/q?query={{$class->label}}&fd={{$class['fdid']}}">{{$class->label}}</a></li>
                  @endforeach
                </ul>
              </div>
              </dd>
            @endforeach
          </dl>
        </div>
       @endif
      <!-- END OF SIDEBAR -->
      <div class="large-10 columns productPart" data-equalizer >
          @if($hasResult)
            <?php 
              $page = new NewPagination();
              $pageNumbers = $page->paginate($products, 20);
              $products = $page->fetchResults();
            ?>

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
                    <p><a target="_blank" href="{{ $product->offer->url }}" class="secondary button">See Product</a></p>
                  </div>
                  <a class="close-reveal-modal">&#215;</a>
                </div>

               
                <img src="{{ $product->image[0]['source'] }}" >

                <ul>
                  <li class="prodName"><a target="_blank" href="{{ $product->offer->url }}">{{$product->label}}</a></li>
                  
                    <p class="pitch">@if($product->offer->pitch){{ $product->offer->pitch }}@endif</p>
                  <li><a href="" data-reveal-id="offer{{$product['oid']}}" class="modal moreinfo">more info</a></li>
                  <li class="price">
                    <span class="before">@if($product->offer->{'price-info'}[0])${{$product->offer->{'price-info'}[0]}}@endif</span> 
                    ${{ $product->offer->price }}
                  </li>
                   <li class="seller"> @if($product['nr-of-merchants'] != 0){{ $product->offer->merchant->label }}@endif</li>
                </ul>
                <a target="_blank" href="{{ $product->offer->url }}" class="secondary button">See it</a>
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
    @if($hasResult)
      <div class="row">
          <ul style="display:hidden" class="pagination">
             @foreach($pageNumbers as $num)
            <?php 
            if(isset($_GET['page'])){
              $curr = $_GET['page'];
            }else{
              $curr = '';
            }

             ?>
              @if($isQueryPage)
                <li><a {{($curr == $num) ? 'class="active"' : ''}} href="{{URL::current()}}?query={{$query}}&page={{$num}}"></a></li>
              @else
                <li><a {{($curr == $num) ? 'class="active"' : ''}} href="{{URL::current()}}?page={{$num}}"></a></li>
              @endif
             @endforeach
          </ul>
        </div>
    @endif
    @stop
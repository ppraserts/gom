<div class="col-md-8" style="background-color:#FFFFFF; padding:20px;">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            @if($productRequest->product1_file != "")
                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            @endif
            @if($productRequest->product2_file != "")
                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            @endif
            @if($productRequest->product3_file != "")
                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
            @endif
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            @if($productRequest->product1_file != "")
                <div class="item crop-height-slide active">
                    <a href="{{ url($productRequest->product1_file) }}" data-lightbox="products"
                       data-title="{{ trans('validation.attributes.product1_file') }}">
                        <img class="scale setHeight" src="{{ url($productRequest->product1_file) }}">
                    </a>
                    <div class="carousel-caption"></div>
                </div>
            @endif
            @if($productRequest->product2_file != "")
                <div class="item crop-height-slide">
                    <a href="{{ url($productRequest->product2_file) }}" data-lightbox="products"
                       data-title="{{ trans('validation.attributes.product2_file') }}">
                        <img class="scale setHeight" src="{{ url($productRequest->product2_file) }}">
                    </a>
                    <div class="carousel-caption"></div>
                </div>
            @endif
            @if($productRequest->product3_file != "")
                <div class="item crop-height-slide">
                    <a href="{{ url($productRequest->product3_file) }}" data-lightbox="products"
                       data-title="{{ trans('validation.attributes.product3_file') }}">
                        <img class="scale setHeight" src="{{ url($productRequest->product3_file) }}">
                    </a>
                    <div class="carousel-caption"></div>
                </div>
            @endif
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" role="button"
           data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button"
           data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
    <br/>
</div>
@extends('master')
@section('content')
<div class="fullwidthbanner-container">
					<div class="fullwidthbanner">
						<div class="bannercontainer" >
					    <div class="banner" >
								<ul>
								@foreach($slide as $sl)
									<li data-transition="boxfade" data-slotamount="20" class="active-revslide" style="width: 100%; height: 100%; overflow: hidden; z-index: 18; visibility: hidden; opacity: 0;">
							            <div class="slotholder" style="width:100%;height:100%;" data-duration="undefined" data-zoomstart="undefined" data-zoomend="undefined" data-rotationstart="undefined" data-rotationend="undefined" data-ease="undefined" data-bgpositionend="undefined" data-bgposition="undefined" data-kenburns="undefined" data-easeme="undefined" data-bgfit="undefined" data-bgfitend="undefined" data-owidth="undefined" data-oheight="undefined">
										<div class="tp-bgimg defaultimg" data-lazyload="undefined" data-bgfit="cover" data-bgposition="center center" data-bgrepeat="no-repeat" data-lazydone="undefined" src="source/image/slide/{{$sl->image}}" data-src="source/image/slide/{{$sl->image}}" style="background-color: rgba(0, 0, 0, 0); background-repeat: no-repeat; background-image: url('source/image/slide/{{$sl->image}}'); background-size: cover; background-position: center center; width: 100%; height: 100%; opacity: 1; visibility: inherit;">
										</div>
										</div>

						        	</li>
					        	@endforeach
								</ul>
							</div>
						</div>

						<div class="tp-bannertimer"></div>
					</div>
				</div>
				<!--slider-->
	</div>
	<div class="container">
		<div id="content" class="space-top-none">
			<div class="main-content">
				<div class="space60">&nbsp;</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="beta-products-list">
							<form action="{{route('sapxep')}}" method="post" style="float: right;">
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<select style="width: 150px; height: 35px;" name="sx">
`									<option value="1">Sắp xếp giá tăng dần</option>
									<option value="2">Sắp xếp giá giảm dần</option>
								</select>
								<button type="submit" class="beta-btn primary">OK</button>
							</form>
							<h4>Sản phẩm</h4>
							<div class="row">
							@foreach($sapxep as $sx)
								<div class="col-sm-3">
									<div class="single-item">	
									@if($sx->promotion_price!=0)
										<div class="ribbon-wrapper"><div class="ribbon sale">Sale</div></div>
									@endif
										<div class="single-item-header">
											<a href="{{route('chitietsanpham',$sx->id)}}"><img src="source/image/product/{{$sx -> image}}" alt="" height="250px"></a>
										</div>
										<div class="single-item-body">
											<p class="single-item-title">{{$sx -> name}}</p>
											<p class="single-item-price">
											@if($sx->promotion_price==0)
												<span class="flash-sale">{{number_format($sx->unit_price)}} đ</span>
											@else
												<span class="flash-del">{{number_format($sx->unit_price)}} đ</span>
												<span class="flash-sale">{{number_format($sx->promotion_price)}} đ</span>
											@endif
											</p>
										</div>
										<div class="single-item-caption">
											<a class="beta-btn primary" href="{{route('chitietsanpham',$sx->id)}}">Chi tiết <i class="fa fa-chevron-right"></i></a>
											<div class="clearfix"></div>
										</div>
									</div>
								</div>
							@endforeach
							</div>
							
						</div> <!-- .beta-products-list -->

						<div class="space50">&nbsp;</div>

						
					</div>
				</div> <!-- end section with sidebar and main content -->


			</div> <!-- .main-content -->
		</div> <!-- #content -->
@endsection
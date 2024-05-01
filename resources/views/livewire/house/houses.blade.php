<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
            <div class="content-header-left col-md-3 col-12 mb-2">
                <div class="row breadcrumbs-top">
                    <div class="col-12">
                        <h2 class="content-header-title float-start mb-0">All Houses</h2>
                        
                    </div>
                </div>
            </div>
            <div class="content-header-right text-md-end col-md-6 col-12 d-md-block d-none">
                <div class="mb-1 breadcrumb-right">
                    <div class="col-sm-12">
                        <div class="input-group input-group-merge">
                            <input type="text" class="form-control search-product" wire:model.live="search"  placeholder="Search By email" >
                            <span class="input-group-text"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search text-muted"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="content-header-left col-md-3 col-12 mb-2">
                
                <div class="row breadcrumbs-top">
                    <div class="dataTables_length" >
                        Type : <label> <select name="page"  wire:model.live="type"  class="form-select">
                            <option value=''>All</option>
                            <option value="0" >For sale  </option>
                            <option value=1 >For Rent  </option>
                            </select>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <!-- Examples -->
            <section id="card-demo-example">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="card">
                            <div class="card-body d-flex align-items-center justify-content-between">
                                <div>
                                    <h3 class="fw-bolder mb-75">{{$houses_count}}</h3>
                                    <span>Total Houses</span>
                                </div>
                                <div class="avatar bg-light-primary p-50">
                                    <span class="avatar-content">
                                        <i data-feather="home" class="font-medium-4"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="row match-height">
                    {{-- cards --}}
                    @foreach ($houses as $house)
                    <div class="col-md-6 col-lg-4">
                        <div class="card">
                            <img class="card-img-top" src="{{asset($house->images[0]->path)}}" alt="Card image cap" />
                            <div class="card-body">
                                <h4 class="card-title">{{$house->is_for_sale==0 ?'For Sale':'For Rent' }}</h4>
                                <p class="card-text">
                                    <b>Price :</b> {{$house->price}} $
                                </p>
                                <p class="card-text">
                                    <b>Space :</b> {{$house->space}} m<sup>2</sup>
                                </p>
                                <a href="#" class="btn btn-outline-primary">Show House</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    
                </div>
            </section>
        </div>
    </div>
</div>

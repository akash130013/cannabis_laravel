<!-- store filters -->
<div class="store-filters">
    <div class="flex-row">
        <div class="flex-col-sm-2">
            <div class="formfilled-wrapper m0">

                <div class="textfilled-wrapper">
                    <div class="select_picker_wrapper">
                        <select class="selectpicker"  id="length">
                                <option value="10">Display 10</option>
                                <option value="25">Display 25</option>
                                <option value="50">Display 50</option>
                                <option value="100">Display 100</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-col-sm-4">
            <div class="formfilled-wrapper m0">
                <div class="textfilled-wrapper">
                    <div class="search-box">
                        <input type="text" id="search" placeholder="{{$searchPlaceholder}}" />
                        <img src="{{asset('asset-admin/images/search-line.svg')}}" alt="" class="hint-icons"
                            alt="search">
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-col-sm-6">
            <div class="right-menu">
                <!-- apply filters -->
                <ul>
                    @if($is_creater == true)
                        <li class="list-filter">
                            <a href="{{route($route_name)}}">
                                <img src="{{asset('asset-admin/images/add-line.svg')}}" alt="user-filter"
                                    data-toggle="modal" data-target="#myModal-add" />
                            </a>
                        </li>
                    @endif
                    @if($is_filterable == true)
                    <li class="list-filter">
                        <a href="javascript:void(0)" id="filter">
                            <img src="{{asset('asset-admin/images/filter-line.svg')}}" alt="user-filter" />
                        </a>
                    </li>
                    @endif
                </ul>
                <!-- apply filters -->
            </div>
        </div>
    </div>
</div>
<!-- store filters -->

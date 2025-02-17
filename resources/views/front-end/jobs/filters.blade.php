<aside id="wt-sidebar" class="wt-sidebar">
    {!! Form::open(['url' => url('search-results'), 'method' => 'get', 'class' => 'wt-formtheme wt-formsearch wt-formbackground']) !!}
        <input type="hidden" value="{{$type}}" name="type">
        <div class="wt-widget wt-effectiveholder wt-startsearch" style=" margin: 0px; ">
            <div class="wt-widgettitle">
                <h2>{{ trans('lang.start_search') }}</h2>
            </div>
            <div class="wt-widgetcontent">
            <span  onclick="myListFunction()"><i id="icon-list" class="fas fa-list"></i></span>
            <span onclick="myGridFunction()"><i id="icon-grid" class="fas fa-th"></i></span>
            
            </div>
        </div>
        <div class="wt-widget wt-effectiveholder">
            <div class="wt-widgettitle">
                <h2>{{ trans('lang.cats') }}</h2>
            </div>
            <div class="wt-widgetcontent">
                <fieldset>
                    <div class="form-group">
                        <input type="text" class="form-control filter-records" placeholder="{{ trans('lang.ph_search_cat') }}">
                        <a href="javascrip:void(0);" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></a>
                    </div>
                </fieldset>
                <fieldset>
                    @if (!empty($categories))
                        <div class="wt-checkboxholder wt-verticalscrollbar">
                            @foreach ($categories as $category)
                                @php $checked = ( !empty($_GET['category']) && in_array($category->slug, $_GET['category'] )) ? 'checked' : ''; @endphp
                                <span class="wt-checkbox">
                                    <input id="cat-{{{ $category->slug }}}" type="checkbox" name="category[]" value="{{{ $category->slug }}}" {{$checked}} >
                                    <label for="cat-{{{ $category->slug }}}"> <a href="{{ url('jobs/'.$category->slug) }}"  >{{{ $category->title }}}</a></label>
                                </span>
                            @endforeach
                        </div>
                    @endif
                </fieldset>
            </div>
        </div>
        <div class="wt-widget wt-effectiveholder">
            <div class="wt-widgettitle">
                <h2>{{ trans('lang.skills') }}</h2>
            </div>
            <div class="wt-widgetcontent">
                <fieldset>
                    @if (!empty($skills))
                        <div class="wt-checkboxholder wt-verticalscrollbar">
                            @foreach ($skills as $key => $skill)
                                @php $checked = (!empty($_GET['skills']) && in_array($skill->slug, $_GET['skills'])) ? 'checked' : '' @endphp
                                <span class="wt-checkbox">
                                    <input id="skill-{{{ $skill->slug }}}" type="checkbox" name="skill[]" value="{{{ $skill->slug }}}" {{$checked}} data-category="{{{ $skill->category_slug }}}">
                                    <label for="skill-{{{ $key }}}"><a href="{{ url('jobs/'.$skill->slug) }}"  >{{{ $skill->title }}}</a></label>
                                </span>
                            @endforeach
                        </div>
                    @endif
                </fieldset>
            </div>
        </div>
        <div class="wt-widget wt-effectiveholder">
            <div class="wt-widgettitle">
                <h2>{{ trans('lang.locations') }}</h2>
            </div>
            <div class="wt-widgetcontent">
                <fieldset>
                    <div class="form-group">
                        <input type="text" class="form-control filter-records" placeholder="{{ trans('lang.ph_search_locations') }}">
                        <a href="javascrip:void(0);" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></a>
                    </div>
                </fieldset>
                <fieldset>
                    @if (!empty($locations))
                        <div class="wt-checkboxholder wt-verticalscrollbar">
                            @foreach ($locations as $location)
                                @php $checked = ( !empty($_GET['locations']) && in_array($location->slug, $_GET['locations'])) ? 'checked' : '' @endphp
                                <span class="wt-checkbox">
                                    <input id="location-{{{ $location->slug }}}" type="checkbox" name="locations[]" value="{{{$location->slug}}}" {{$checked}} >
                                    <label for="location-{{{ $location->slug }}}">
                                        <a href="{{ url('jobs/'.$location->slug) }}" class="anchor-content-center" >
                                            <img src="{{{asset(Helper::getLocationFlag($location->flag))}}}" alt="{{ trans('lang.img') }}" style="width:25px;height:18px">
                                            <div class="location-name">{{{ $location->title }}}</div>
                                        </a>
                                    </label>
                                </span>
                            @endforeach
                        </div>
                    @endif
                </fieldset>
            </div>
        </div>
        
        <div class="wt-widget wt-effectiveholder">
            <div class="wt-widgettitle">
                <h2>{{ trans('lang.project_length') }}</h2>
            </div>
            <div class="wt-widgetcontent">
                <fieldset>
                    @if (!empty($project_length))
                        <div class="wt-checkboxholder">
                            @foreach ($project_length as $key => $length)
                                @php $checked = ( !empty($_GET['project_lengths']) && in_array($key, $_GET['project_lengths'])) ? 'checked' : '' @endphp
                                <span class="wt-checkbox">
                                    <input id="{{{ $key }}}" type="checkbox" name="project_lengths[]" value="{{{$key}}}" {{$checked}}>
                                    <label for="{{{ $key }}}"><a href="{{ url('jobs/'.$key) }}"  >{{{ $length }}}</a></label>
                                </span>
                            @endforeach
                        </div>
                    @endif
                </fieldset>
            </div>
        </div>
        <div class="wt-widget wt-effectiveholder">
            <div class="wt-widgettitle">
                <h2>{{ trans('lang.langs') }}</h2>
            </div>
            <div class="wt-widgetcontent">
                <fieldset>
                    <div class="form-group">
                        <input type="text" class="form-control filter-records" placeholder="{{ trans('lang.ph_search_langs') }}">
                        <a href="javascrip:void(0);" class="wt-searchgbtn"><i class="lnr lnr-magnifier"></i></a>
                    </div>
                </fieldset>
                <fieldset>
                    @if(!empty($languages))
                        <div class="wt-checkboxholder wt-verticalscrollbar">
                            @foreach ($languages as $language)
                                @php $checked = ( !empty($_GET['languages']) && in_array($language->slug, $_GET['languages'])) ? 'checked' : '' @endphp
                                <span class="wt-checkbox">
                                    <input id="language-{{{ $language->slug }}}" type="checkbox" name="languages[]" value="{{{$language->slug}}}" {{$checked}} >
                                    <label for="language-{{{ $language->slug }}}"><a href="{{ url('jobs/'.$language->slug) }}"  >{{{ $language->title }}}</a></label>
                                </span>
                            @endforeach
                        </div>
                    @endif
                </fieldset>
            </div>
        </div>
        <div class="wt-widget wt-effectiveholder">
            <div class="wt-widgetcontent">
                <div class="wt-applyfilters">
                    <span>{{ trans('lang.apply_filter') }}<br> {{ trans('lang.changes_by_you') }}</span>
                    {!! Form::submit(trans('lang.btn_apply_filters'), ['class' => 'wt-btn']) !!}
                </div>
            </div>
        </div>
    {!! Form::close() !!}
</aside>


<script type="application/javascript">
function myListFunction() {
    document.getElementById("grid-layout").style.display = "none";
    document.getElementById("list-layout").style.display = "block";
    document.getElementById("icon-grid").style.color = "#ffffff8a";
    document.getElementById("icon-list").style.color = "#ffffff";
}

function myGridFunction() {
    document.getElementById("list-layout").style.display = "none";
    document.getElementById("grid-layout").style.display = "block";
    document.getElementById("icon-grid").style.color = "#ffffff";
    document.getElementById("icon-list").style.color = "#ffffff8a";
}
</script>

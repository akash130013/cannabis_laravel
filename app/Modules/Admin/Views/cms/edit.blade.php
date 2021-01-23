@extends('Admin::includes.layout')


@section('content')
    <div class="wrapper">
        <!-- Side menu start here -->
        @include('Admin::includes.sidebar')
        <!-- Side menu ends here -->
        <div class="right-panel">
                @include('Admin::includes.header')
            <div class="inner-right-panel">
              <div class="breadcrumb-section">
                <ul class="breadcrumb">
                    <li><a href="{{route('admin.cms.index')}}">CMS</a></li>
                <li class="active">{{$data->name}}</li> 
                </ul>
              </div>
              <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
              <form action="{{route('admin.cms.update',$data->id)}}" method="POST">
                @csrf
                @method('PUT')
               <div class="detail-screen">
                  <div class="row">
                      <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="form-group product">
                              <label class="form-label">Page Name</label>
                          <input type="text" name="product_name" disabled class="form-control" placeholder="Name" value="{{$data->name}}">
                          </div>
                      </div>
        
                  </div>
                  <div class="row">
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <textarea name="content" class="form-control my-editor">{!! old('content', $data->content) !!}</textarea>
                        </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-sm-12">
                          <div class="form-group">
                          <div class="btn-holder clearfix">
                              <button type="submit" class="green-fill-btn">Update</button>
                          </div>
                      </div>
                      </div>
                  </div>
               </div>
              </form>
              
              <input type="hidden" id="absolute_url" value="{{url('/')}}">
            </div>
            
       
      </div>

<script>
  var editor_config = {
    path_absolute : "/",
    selector: "textarea.my-editor",
    absolute_url : document.getElementById('absolute_url').value,
    // plugins: [
    //   "advlist autolink lists hr anchor",
    //   "searchreplace wordcount visualblocks visualchars",
    //   "insertdatetime nonbreaking save table",
    //   "textcolor colorpicker textpattern"
    // ],
    toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent",
    relative_urls: false,
    file_browser_callback : function(field_name, url, type, win) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;
      var cmsURL = editor_config.absolute_url + '/admin/laravel-filemanager?field_name=' + field_name;
      if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Filemanager',
        width : x * 0.8,
        height : y * 0.8,
        resizable : "yes",
        close_previous : "no"
      });
    }
  };

  tinymce.init(editor_config);
</script>
    </div>
@endsection
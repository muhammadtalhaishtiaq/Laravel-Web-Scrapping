<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Web Crawler</title>
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v5.12.1/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="{{asset('web/css/styles.css')}}" rel="stylesheet" />
    </head>
    <body id="page-top">
       <div id='loader' 
                    style='display: none;
                    position: absolute;
                    z-index: 99999;
                    left: 41%;
                    top: 42%;'>
                 <img src="{{asset('web/img/load.gif')}}" style="width: 60%;height: 0%">
            </div>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg bg-secondary text-uppercase fixed-top" id="mainNav" style="height: 10%;">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href="#page-top">Web Crawler</a>
            </div>
        </nav>
        <!-- Portfolio Section-->
        <section class="page-section portfolio" id="portfolio">
            
            <div class="container">
                <!-- Portfolio Section Heading-->
                <h3 class="page-section-heading text-center text-uppercase text-secondary mb-0">Crawled News</h3>
                <!-- Icon Divider-->
                <div class="divider-custom">
                    <div class="divider-custom-line"></div>
                    <div class="divider-custom-icon"><i class="fas fa-star"></i></div>
                    <div class="divider-custom-line"></div>
                </div>
                <div style="text-align: right;">
                    <a href="" class="btn btn-success load" style="margin-bottom:1%;" id="load">Load</a>
                    <a href="" class="btn btn-warning" style="margin-bottom:1%;" id="re_load" >Refresh</a>
                </div>
                <!-- Portfolio Grid Items-->
                <div class="row">
                    <table class="table" id="fetch_news">
                      <thead class="thead-dark">
                        <tr>
                          <th scope="col">Id</th>
                          <th scope="col">Title</th>
                          <th scope="col">Points</th>
                          <th scope="col">Username</th>
                          <th scope="col">Total Comments</th>
                          <th scope="col">Time Stamp</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($news as $new)
                        <tr class="news_row" id="tr_{{$new->id}}">
                            <th>{{$new->id}}</th>
                            <th><a href="{{$new->url}}">{{$new->title}}</th>
                            <th>{{$new->points}}</th>
                            <th>{{$new->username}}</th>
                            <th>{{$new->total_comments}}</th>
                            <th>{{htmlentities($new->time_stamp)}}</th>
                            <th><a href="javascript:void(0)" class="btn btn-danger btn-sm" id="{{$new->id}}" onclick="delete_news(this);">Delete</a></th>
                        </tr>
                        @endforeach
                        
                      </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes)-->
        <div class="scroll-to-top d-lg-none position-fixed">
            <a class="js-scroll-trigger d-block text-center text-white rounded" href="#page-top"><i class="fa fa-chevron-up"></i></a>
        </div>
        <!-- Bootstrap core JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
        <!-- Third party plugin JS-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
        <!-- Core theme JS-->
        <script src="{{asset('web/js/scripts.js')}}"></script>
        <script type="text/javascript">
                $('#load').click(function (e) {
                    e.preventDefault();
                    $("#loader").show();
                    $.ajax({
                      url: "{{ route('load_data') }}",
                      type: "POST",
                      data: {
                            "_token": "{{ csrf_token() }}",
                            },
                      success: function (data) {
                        $("#loader").hide();
                        $news = JSON.parse(data);
                        console.log($news);
                        if($news != 0){
                            for(var i =0; i < 30 ; i++){
                                var html = '<tr class=news_row id="tr_'+$news[i]['id']+'">';
                                html += '<td>'+$news[i]['id']+'</td>';
                                html += '<td><a href="'+$news[i]['url']+'" target="_blank">'+$news[i]['title']+'</a></td>';
                                html += '<td>'+$news[i]['points']+'</td>';
                                html += '<td>'+$news[i]['username']+'</td>';
                                html += '<td>'+$news[i]['total_comments']+'</td>';
                                html += '<td>'+$news[i]['time_stamp']+'</td>';
                                html += '<td><a href="javascript:void(0)" class="btn btn-danger btn-sm" id="'+$news[i]['id']+'" onclick="delete_news(this);">Delete</a></td>';
                                html += '</tr>';
                                $('#fetch_news').append(html);                      
                            }
                        }
                      },
                      error: function (data) {
                          console.log('Error:', data);
                      }
                  });
                });

                $('#re_load').click(function (e) {
                    e.preventDefault();
                    $("#loader").show();
                    $.ajax({
                      url: "{{ route('re_load_data') }}",
                      type: "POST",
                      data: {
                            "_token": "{{ csrf_token() }}",
                            },
                      success: function (data) {
                        $("#loader").hide();
                        $('.news_row').remove();
                        $news = JSON.parse(data);
                        for(var i =0; i < 30 ; i++){
                            var html = '<tr class=news_row id="tr_'+$news[i]['id']+'">';
                            html += '<td>'+$news[i]['id']+'</td>';
                            html += '<td><a href="'+$news[i]['url']+'" target="_blank">'+$news[i]['title']+'</a></td>';
                            html += '<td>'+$news[i]['points']+'</td>';
                            html += '<td>'+$news[i]['username']+'</td>';
                            html += '<td>'+$news[i]['total_comments']+'</td>';
                            html += '<td>'+$news[i]['time_stamp']+'</td>';
                             html += '<td><a href="javascript:void(0)" class="btn btn-danger btn-sm" id="'+$news[i]['id']+'" onclick="delete_news(this);">Delete</a></td>';
                            html += '</tr>';
                            $('#fetch_news').append(html);                      
                        }
                      },
                      error: function (data) {
                          console.log('Error:', data);
                      }
                  });
                });        
                function delete_news(obj){
                    id = $(obj).attr("id");
                    $.ajax({
                      url: "{{ route('delete_news') }}",
                      type: "POST",
                      data: {
                            "_token": "{{ csrf_token() }}",
                            id:id
                            },
                      success: function (data) {
                            $('#tr_' + id).fadeOut();
                      },
                      error: function (data) {
                          console.log('Error:', data);
                      }
                    });
                }        
        </script>
    </body>
</html>

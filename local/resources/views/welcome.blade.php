<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{asset('local/public')}}/style.css">
</head>

<body>
    <div class="content-area">
    <div class="flex-center position-ref full-height">
        <div class="content">
            <!-- TODO: Missing CoffeeScript 2 -->
            <section class="todoapp">
                <header class="header">
                    <h1>todos</h1>
                    <form method="post" id="todoSubmit">
                    <input type="text" autocomplete="off" placeholder="What needs to be done?" class="new-todo" name="title" required>
                     
                     </form>
                </header>
                <section class="main tab_content tab_content_active" id="tabcontent1">
                    <ul class="todo-list">
                        @foreach($todoinfo as $active_task)

                        <li class="todo" id="allTask" style="
                        @if($active_task->status==0)
                        text-decoration: line-through;
                        opacity: 0.5
                        @endif
                        ">
                            <div class="view">
                                <form class="changeStatus" method="post">
                                <input type="checkbox" id="{{$active_task->id}}" class="toggle status_bar" name="status" value="0">
                                </form>
                                <label class="title_text" id="data{{$active_task->id}}">{{$active_task->title}}</label>
                                <button class="destroy" data-id="{{$active_task->id}}"  data-token="{{ csrf_token() }}"></button>
                                  
                            </div>
                             <form action="javascript::void(0)"class="updateTask" method="post" onblur="shamim()">
                            <input onblur="update({{$active_task->id}})" type="text" class="edit data{{$active_task->id}}" value="{{$active_task->title}}" id="data{{$active_task->id}}" name="title" data-token="{{ csrf_token() }}">
                            </form>
                        </li>
                        @endforeach
                    </ul>
                </section> 

             <section class="main tab_content" id="tabcontent2">
                    <ul class="todo-list">
                        @foreach($activeTask as $activeTaskdata)
                        
                        <li class="todo" id="allTask" style="
                        @if($activeTaskdata->status==0)
                        text-decoration: line-through;
                        opacity: 0.5
                        @endif
                        ">
                            <div class="view">
                                <form class="changeStatus" method="post">
                                <input type="checkbox" id="{{$activeTaskdata->id}}" class="toggle status_bar" name="status[]" value="0">
                                </form>
                                <label>{{$activeTaskdata->title}}</label>
                                <button class="destroy" data-id="{{$activeTaskdata->id}}"  data-token="{{ csrf_token() }}"></button>
                                  
                            </div>
                            <input type="text" class="edit">
                        </li>
                        @endforeach
                    </ul>
                </section>

                <section class="main tab_content" id="tabcontent3">
                    <ul class="todo-list">
                        @foreach($Taskcompleted as $Taskcompletedinfo)
                        
                        <li class="todo" id="allTask" style="
                        @if($Taskcompletedinfo->status==0)
                        text-decoration: line-through;
                        opacity: 0.5
                        @endif
                        ">
                            <div class="view">
                                <form class="changeStatus" method="post">
                                <input type="checkbox" id="{{$Taskcompletedinfo->id}}" class="toggle status_bar" name="status[]" value="0">
                                </form>
                                <label>{{$Taskcompletedinfo->title}}</label>
                                <button class="destroy" data-id="{{$Taskcompletedinfo->id}}"  data-token="{{ csrf_token() }}"></button>
                                  
                            </div>
                            <input type="text" class="edit">
                        </li>
                        @endforeach
                    </ul>
                </section>




                <footer class="footer"><span class="todo-count"><strong>{{$leftTask}}</strong> item left
                </span>
                    <ul class="filters">

                          <li>
                            <a href="javascript:void(0); return false;" rel="#tabcontent1" class="tab ">All</a>
                        </li>
                        <li>
                          <a href="javascript:void(0); return false;" rel="#tabcontent2" class="tab">active</a>
                        </li>
                          <li>
                          <a href="javascript:void(0); return false;" rel="#tabcontent3" class="tab">Completed</a>
                        </li>






                    </ul>
                    <button class="clear-completed" data-token="{{ csrf_token() }}">
                        Clear completed
                    </button>
                </footer>
            </section>

        </div>
    </div>
    </div>


<script src="{{asset('local/public/')}}/jquery.min.js"></script>


<script type="text/javascript"> 
 $(document).ready(function(){
    $(".new-todo" ).focus();
    //-------- Tab making script --------------//
    $(".filters li a").click(function() {
        $(".filters li a").removeClass("active selected");
        $(this).addClass("active selected");
        $(".tab_content_active").removeClass("tab_content_active").fadeOut(200);
        $(this.rel).addClass("tab_content_active");
        
    }); 

   //-------- Data Insert with Ajax --------------//
    $("#todoSubmit").submit(function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
       });
         var realodUrl='{{route("todos.index")}}';
         var url='{{route("todos.store")}}';
         var data = $(this).serialize();
         $.ajax({
           url:url,
           method:'POST',
           data:data,
           success:function(data){
              console.log(data);
               $('body').load(realodUrl);
           },
           error:function(error){
            console.log(error);
           }
        });
    });


 //-------- Data edit with Ajax --------------//
  $( ".title_text" ).dblclick(function() {
      var id = $(this).attr('id');
      $("#"+id).hide();
      $( "."+id ).show();
      $( "."+id ).focus();
     });


//-------- Delete single data with Ajax --------------//
    $('.destroy').click(function(e){
       e.preventDefault();
       var id=$(this).data('id');
       var realodUrl='{{route("todos.index")}}';
       var url='{{route("todos.destroy",":id")}}';
       var url = url.replace(':id', id);
       var token = $(this).data("token");
        $.ajax({
           url:url,
           type:'POST',
           data:{'_method':'DELETE','_token': token },
           success:function(data){
             $('body').load(realodUrl);
             console.log(data);
             $('#'+id).hide();
           }
       });

     });

  //-------- Delete All data with Ajax --------------//
    $('.clear-completed').click(function(){
       var realodUrl='{{route("todos.index")}}';
        var url='{{route("delteAll")}}';
         var token = $(this).data("token");
      $.ajax({
           url:url,
           method:'get', 
           success:function(data){
              console.log(data);
              $('body').load(realodUrl);
           },
           error:function(error){
            console.log(error);
           }
        });
    });







   //-------- Task Status Update with Ajax --------------//
    $('.status_bar').on('click',function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
       });
        var id = $(this).attr('id');
        var realodUrl='{{route("todos.index")}}';
        var url='{{route("deactive",":id")}}';
        var url = url.replace(':id', id);
        var data=$('.changeStatus').serialize();
         $.ajax({
           url:url,
           method:'get',
           data:data,
           success:function(data){
              console.log(data.message);
              $('body').load(realodUrl);
           },
           error:function(error){
            console.log(error);
           }
        });

    });
});

</script>





  <script type="text/javascript"> 

    

     // remove current edit when click other
      function update(id){
        var editId= id;
         $(".data"+editId).hide();
         $('.title_text').show();

     $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
       });
       var realodUrl='{{route("todos.index")}}';
       var url='{{route("todos.update",":id")}}';
       var url = url.replace(':id', id);
       var data = $('.edit'+'.data'+id).val();
       var token = $(this).data("token");
      $.ajax({
           url:url,
           type:'POST',
           data:{'data':data,'_method':'put','_token': token }, 
           success:function(data){
             $('body').load(realodUrl);
             console.log(data.message);
           }
       });

      };


  </script>



</body>

</html>
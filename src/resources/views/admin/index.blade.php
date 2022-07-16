@extends('basic::admin.layouts.basic')

@section('pagecontent')

    <div class="big-container" id="app">

        @php
        /* $routeCollection = Route::getRoutes();

foreach ($routeCollection as $value) {
    echo $value->getName();
    echo '<br>';
}
echo '!!'; */
    @endphp
<form action="" method="post" id="tfrm">
    @csrf
            @method('POST')
    <input type="text" name="name" id="name">
    <button type="submit">Send</button>
</form>

        <script>
            function ttt () {
                fetch('/admin/blog/tags/1',{
                        method: 'GET',
                        headers: {
                            //'Content-Type': 'multipart/form-data',
                            //'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        //credentials: 'same-origin',
                        //body: ''
                    }).then(
                        (result) => result.text()
                    ).then (
                        (data) => {
                            console.log(data)
                            /* if (box) {
                                box.innerHTML = data;
                            } */
                        }
                    ).catch(error => {
                        //
                    });
            }


//function fff (){
             const form = document.querySelector('#tfrm')
            const box = document.querySelector('#result')
            const token = document.querySelector("input[name='_token']").value;
            if (form) {
                //let query = new FormData(form)
                //console.log(query)
                form.addEventListener('submit',function(e){
                    e.preventDefault()
                    let query = new FormData(form)
                    let data = {};

                    for (let [key, prop] of query) {
                        data[key] = prop;
                    }
                    data = JSON.stringify(data);
                    console.log(data);
                    fetch('/admin/blog/tags/addnotexist',{
                        method: 'POST',
                        headers: {
                            //'Content-Type': 'multipart/form-data',
                            //'Content-Type': 'application/x-www-form-urlencoded',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': token,
                        },
                        credentials: 'same-origin',
                        body: data
                    }).then(
                        (result) => result.text()
                    ).then (
                        (data) => {
                            console.log(data)
                            /* if (box) {
                                box.innerHTML = data;
                            } */
                        }
                    ).catch(error => {
                        //
                    });
                })

            }
        //}
        </script>
    </div>

@endsection

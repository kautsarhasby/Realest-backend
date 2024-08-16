<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body>
    <form action="" onsubmit="submitted(event)" method="POST" class="form">
        @csrf
        <input type="text"  placeholder="Name" id="name" name="name">
        <button type="submit">SUBMIT WAK</button>
    </form>
    <script >
        function submitted(e){
            e.preventDefault();
            const name =document.querySelector('#name').value;
            const form =document.querySelector('.form')
            const formData = new FormData(form);
            formData.append('name',name);
            
            fetch("{{ route('user') }}",{
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log(form)
                    console.log(response)
                    
                    if (!response.ok) {
                        throw new Error('Terjadi kesalahan login');
                    }
                    return response.text();
                })
                .then(data => {
                    console.log(JSON.parse(data));
                    const newData =JSON.parse(data);
                    
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
</body>
</html>
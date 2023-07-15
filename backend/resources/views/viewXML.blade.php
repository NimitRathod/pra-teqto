<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>{{ env("APP_NAME",'Laravel') }}</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />
    
</head>
<body>
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid text-center">
            <a class="navbar-brand text-center" href="#">
                <img src="data:image/png;base64,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" alt="" width="100" class="d-inline-block align-text-top">
            </a>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table" id="basic-datatables">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Company</th>
                                <th scope="col">Country</th>
                                <th scope="col">Location</th>
                                <th scope="col">Zip Code</th>
                                <th scope="col">Application Type</th>
                                {{-- <th scope="col">Description</th> --}}
                                <th scope="col">Lang</th>
                                <th scope="col">Employment Type</th>
                                <th scope="col">Occupation</th>
                                <th scope="col">Degree Level</th>
                                <th scope="col">Years of Experience</th>
                                <th scope="col">Salary Range</th>
                                <th scope="col">Languages</th>
                                <th scope="col">Skills</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($collection)
                            @foreach ($collection as $item)
                            <tr>
                                <th >{{ $item['id'] ?? ''}}</th>
                                <th >{{ $item['title'] ?? ''}}</th>
                                <th >{{ $item['company'] ?? ''}}</th>
                                <th >{{ $item['country'] ?? ''}}</th>
                                <th >{{ $item['location'] ?? '' }}</th>
                                <th >{{ $item['zip_code'] ?? ''}}</th>
                                <th >{{ $item['application_type'] ?? '' }}</th>
                                {{-- <th >{{ $item['description'] ?? '' }}</th> --}}
                                <th >{{ $item['lang'] ?? ''}}</th>
                                <th >{{ $item['employment_type'] ?? '' }}</th>
                                <th >{{ $item['occupation'] ?? '' }}</th>
                                <th >{{ $item['degree_level'] ?? '' }}</th>
                                <th >{{ $item['years_of_experience'] ?? '' }}</th>
                                {{-- <th >{!! (isset($item['languages'])) ? $item['languages'] : '' !!}</th> --}}
                                <th ></th>
                                <th ></th>
                                <th ></th>
                                {{-- <th >{{ ($item->languages) ? explode(',',$item->languages) :  '' }}</th> --}}
                                {{-- <th >{{ implode(',',$item->skills) ?? '' }}</th> --}}
                            </tr> 
                            @endforeach
                            
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    
    <script>
        $('#basic-datatables').DataTable({
            "columnDefs": [ {
                "targets": 'no-sort',
                "orderable": false,
            } ]
        });
    </script>
</body>
</html>

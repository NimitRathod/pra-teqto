<script>
    $(".select_category").on('change', function () {
        let category_id = $(this).val();
        let _url = "{{ env('APP_URL') }}";
        if(category_id){
            _url = _url+"api/subcategories/"+category_id;
            let category_options = '<option selected value="">Select Sub Category</option>';
            $(".select_subcategory").empty();
            $.ajax({
                url: _url,
                type: "GET",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success: function(response){
                    if(response.success){
                        
                        if(response.data && response.data.length > 0){
                            let res_data = response.data;
                            
                            $.each(res_data,  function(key, value) {
                                category_options += '<option value="'+value.id+'">'+value.name+'</option>';
                            });
                            $(".select_subcategory").empty().html(category_options);
                        }
                    }
                }, 
                error: function(errors){
                    console.log("Get Category Error ",errors);
                }
            });
        }
    });
</script>
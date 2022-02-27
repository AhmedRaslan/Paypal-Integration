<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test | Admin</title>
    <!-- Datatable CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" />
    <!-- jQuery Library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Datatable JS -->
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <table id='ordersTable' width='100%' border="2" style='border-collapse: collapse;'>
        <thead>
            <tr>
                <td>Order ID</td>
                <td>Amount</td>
                <td>Status</td>
                <td>Created at</td>
                <td>Updated at</td>
            </tr>
        </thead>
    </table>

    <!-- Script -->
    <script type="text/javascript">
        $(document).ready(function() {

            // DataTable
            $('#ordersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.orders') }}",
                columns: [{
                        data: 'order_id'
                    },
                    {
                        data: 'amount'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'updated_at'
                    },
                ]
            });
        });
    </script>
</body>

</html>

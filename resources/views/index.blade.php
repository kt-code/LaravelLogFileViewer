<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ isset($title) ? $title : '' }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-touch-icon.png">
    <!-- Place favicon.ico in the root directory -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
          crossorigin="anonymous">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp"
          crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.15/css/dataTables.bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/responsive/2.1.1/css/responsive.bootstrap.min.css"/>
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/main.css">
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
</head>
<body>
    <div class="container-fluid">

        <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        {{--Page header--}}
        <div class="page-header">
            <h1>Log File Viewer
                <small>View specific file under server log directory</small>
            </h1>
        </div>

        <!--File path input-->
        <div class="form-group">
            <div class="col-sm-10">
                <div class="input-group">
                    <span class="input-group-addon">{{ $log_dir_path }}</span>
                    <input type="text" name="path" id="path" class="form-control" placeholder="filename.log" value="{{ $log_default_file }}" required="required">
                </div>
            </div>
            <div class="col-sm-2">
                <input type="button" name="view" id="view" class="form-control btn btn-default" value="View" title="View the log file content">
            </div>
        </div>
        <!--Datatables-->
        <table id="content" class="display table table-striped table-hover" width="100%">
            <thead>
            <tr>
                <th class="col-sm-2">Line</th>
                <th class="col-sm-10">Content</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="col-sm-2"></td>
                <td class="col-sm-10"></td>
            </tr>
            </tbody>
        </table>

        {{--Scripts--}}
        <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.12.0.min.js"><\/script>')</script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
                crossorigin="anonymous"></script>
        <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="//cdn.datatables.net/1.10.15/js/dataTables.bootstrap.min.js"></script>
        <script type="text/javascript" src="//cdn.datatables.net/responsive/2.1.1/js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" src="//cdn.datatables.net/responsive/2.1.1/js/responsive.bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/main.js"></script>

        {{--Datatables--}}
        <script>
            $(document).ready(function () {
                var table = $('#content').DataTable({
                    "paging": true,
                    "lengthChange": false,
                    "processing": true,
                    "searching": false,
                    "serverSide": true,
                    "ordering": false,
                    "info": false,
                    "deferLoading": true,
                    "responsive": true,
                    "ajax": {
                        "url": "log",
                        "data": function (d) {
                            d.path = $('#path').val();
                        }
                    },
                });

                /**
                 *
                 */
                $('#view').click(function () {
                    console.log('View clicked!');
                    table.ajax.reload();
                });
            });
        </script>

    </div>
</body>
</html>

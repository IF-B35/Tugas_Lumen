<html>
    <head>
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"/>
    </head>

    <body>
        <div class="container">
            <h1>List Post</h1>
            <table class = "table table-striped">
                <tbody>
                    <tr>
                        <td>ID</td>
                        echo "<td>" . $result['id'] . "</td>";
                    </tr>
                    <tr>
                        <td>User ID</td>
                        <td><?php if (isset($result['data']['user_id'])) {
                                echo $result['data']['user_id'];}  ?></td>
                    </tr>
                    <tr>
                        <td>Title</td>
                        <td><?php if (isset($result['data']['title'])) {
                                echo $result['data']['title'];} ?></td>
                    </tr>
                    <tr>
                        <td>Content</td>
                        <td><?php if (isset($result['data']['content'])) {
                                echo $result['data']['content'];} ?></td>
                    </tr>
                    <tr>
                        <td>Status</td>
                        <td><?php if (isset($result['data']['status'])) {
                                echo $result['data']['status'];} ?></td>
                    </tr>
                    <tr>
                        <td>Created At</td>
                        <td><?php if (isset($result['data']['created_at'])) {
                                echo $result['data']['created_at'];} ?></td>
                    </tr>
                    <tr>
                        <td>Updated At</td>
                        <td><?php if (isset($result['data']['updated_at'])) {
                                echo $result['data']['updated_at'];} ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>
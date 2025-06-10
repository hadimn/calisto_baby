<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: loginpage.php");
    exit();
}

require_once '../classes/Database.php';
require_once '../classes/banner_messages.php';

$database = new Database();
$db = $database->getConnection();
$banner = new BannerMessage($db);
$messages = $banner->getAll()->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Banner Messages</title>
    <style>
        .sortable-list {
            list-style: none;
            padding: 0;
        }

        .sortable-item {
            padding: 10px;
            margin-bottom: 5px;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            cursor: move;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .toggle-btn {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-center">Manage Banner Messages</h2>
        <ul id="sortable" class="sortable-list">
            <?php foreach ($messages as $msg): ?>
                <li class="sortable-item" data-id="<?= $msg['id']; ?>">
                    <span class="message-text"><i class="fa fa-bars" aria-hidden="true"></i> <?= htmlspecialchars($msg['message']); ?></span>
                    <input type="text" class="edit-input" style="display:none; flex: 1; margin-right: 10px;">
                    <div>
                        <button class="btn btn-sm <?= $msg['is_active'] ? 'btn-success' : 'btn-secondary'; ?> toggle-btn">
                            <?= $msg['is_active'] ? 'Active' : 'Inactive'; ?>
                        </button>
                        <button class="btn btn-sm btn-warning edit-btn">Edit</button>
                        <button class="btn btn-sm btn-primary save-btn" style="display:none;">Save</button>
                        <button class="btn btn-sm btn-danger delete-btn">Delete</button>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function() {
            // Toggle activation
            $('.toggle-btn').click(function() {
                const button = $(this);
                const item = button.closest('.sortable-item');
                const id = item.data('id');
                $.post('proccess/toggle_banner_status.php', {
                    id: id
                }, function(response) {
                    if (response.success) {
                        button.toggleClass('btn-success btn-secondary');
                        button.text(button.hasClass('btn-success') ? 'Active' : 'Inactive');
                    }
                }, 'json');
            });

            // Enable sorting
            $('#sortable').sortable({
                update: function(event, ui) {
                    const order = $(this).children().map(function(index, element) {
                        return {
                            id: $(element).data('id'),
                            order: index
                        };
                    }).get();
                    $.post('proccess/update_banner_order.php', {
                        order: order
                    }, function(response) {
                        if (!response.success) {
                            alert('Failed to update order.');
                        }
                    }, 'json');
                }
            });

            // Toggle to edit mode
            $('.edit-btn').click(function() {
                const item = $(this).closest('.sortable-item');
                const span = item.find('.message-text');
                const input = item.find('.edit-input');
                const saveBtn = item.find('.save-btn');

                input.val(span.text()).show();
                span.hide();
                $(this).hide();
                saveBtn.show();
            });

            // Save edit
            $('.save-btn').click(function() {
                const item = $(this).closest('.sortable-item');
                const id = item.data('id');
                const input = item.find('.edit-input');
                const span = item.find('.message-text');
                const editBtn = item.find('.edit-btn');
                const newMessage = input.val();

                $.post('proccess/update_banner_message.php', {
                    id: id,
                    message: newMessage
                }, function(response) {
                    if (response.success) {
                        span.text(newMessage).show();
                        input.hide();
                        editBtn.show();
                        item.find('.save-btn').hide();
                    } else {
                        alert('Update failed.');
                    }
                }, 'json');
            });

            // Delete banner
            $('.delete-btn').click(function() {
                if (!confirm('Are you sure you want to delete this banner message?')) return;

                const item = $(this).closest('.sortable-item');
                const id = item.data('id');
                console.log(id);

                $.post('proccess/delete_banner_message.php', {
                    id: id
                }, function(response) {
                    if (response.success) {
                        item.remove();
                    } else {
                        alert('Failed to delete message.');
                    }
                }, 'json');
            });

        });
    </script>
</body>

</html>
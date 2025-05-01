<?php
if (!isset($_SESSION['admin_id'])) {
    header("Location: loginpage.php");
    exit();
}

@include('proccess/socialmedia_proccess.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Social Media Page</title>
    <style>
        ::placeholder {
            color: black !important;
            opacity: 1;
        }

        .color-option {
            width: 20px;
            height: 20px;
            display: inline-block;
            margin-right: 8px;
            border-radius: 50%;
            border: 2px solid #dee2e6;
            vertical-align: middle;
        }

        .color-option.selected {
            border-color: #000;
            box-shadow: 0 0 0 2px #fff, 0 0 0 3px #000;
        }

        .color-preview {
            width: 20px;
            height: 20px;
            display: inline-block;
            border-radius: 50%;
            border: 1px solid #dee2e6;
        }

        .platform-icon {
            width: 32px;
            text-align: center;
        }
    </style>
    <!-- pickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css" />
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Manage Social Media Platforms</h1>

        <form method="POST" class="border p-4 rounded shadow-sm bg-light">
            <?php
            $database = new Database();
            $db = $database->getConnection();
            $socialMedia = new SocialMedia($db);
            $platforms = $socialMedia->getAllSocialMedia();

            $colorOptions = [
                'bg-primary' => '#0d6efd',
                'bg-secondary' => '#6c757d',
                'bg-success' => '#198754',
                'bg-danger' => '#dc3545',
                'bg-warning' => '#ffc107',
                'bg-info' => '#0dcaf0',
                'bg-light' => '#f8f9fa',
                'bg-dark' => '#212529',
                'bg-white' => '#ffffff',
                'bg-transparent' => 'transparent'
            ];

            if ($platforms) {
                foreach ($platforms as $platform) {
                    $platformColor = $platform['bg_color'] ?? 'bg-primary';
            ?>
                    <div class="row mb-3 align-items-center">
                        <div class="col-md-2 d-flex align-items-center">
                            <div class="platform-icon">
                                <i class="<?= htmlspecialchars($platform['icon_class']) ?> fa-lg"></i>
                            </div>
                            <span class="fw-bold ms-2"><?= htmlspecialchars($platform['platform']) ?></span>
                        </div>
                        <div class="col-md-4">
                            <input type="url"
                                name="links[<?= $platform['social_id'] ?>]"
                                class="form-control"
                                placeholder="Enter link"
                                value="<?= htmlspecialchars($platform['link']) ?>">
                        </div>
                        <div class="col-md-2">
                            <div class="form-check form-switch">
                                <input type="checkbox"
                                    name="enabled[<?= $platform['social_id'] ?>]"
                                    class="form-check-input"
                                    id="enabled-<?= $platform['social_id'] ?>"
                                    <?= ($platform['enabled'] ? 'checked' : '') ?>>
                                <label class="form-check-label" for="enabled-<?= $platform['social_id'] ?>">Enabled</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div id="color-picker-<?= $platform['social_id'] ?>"></div>
                            <input type="hidden" name="colors[<?= $platform['social_id'] ?>]" id="rgba-color-<?= $platform['social_id'] ?>" value="<?= htmlspecialchars($platform['bg_color'] ?? 'rgba(13,110,253,1)') ?>">

                        </div>
                        <div class="col-md-2">
                            <button type="submit" name="update_social_media" class="btn btn-primary w-100">Update</button>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p class="text-center">No social media platforms found.</p>';
            }
            ?>
        </form>
    </div>

    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script>
        function setColor(socialId, colorClass) {
            // Update the hidden input value
            document.getElementById('color-input-' + socialId).value = colorClass;

            // Update the color preview in the dropdown button
            const dropdownBtn = document.getElementById('color-dropdown-' + socialId);
            const previewSpan = dropdownBtn.querySelector('.color-preview');

            // Remove all color classes and add the selected one
            previewSpan.className = 'color-preview ' + colorClass;

            // Update selected state in dropdown
            const dropdownMenu = dropdownBtn.nextElementSibling;
            const colorOptions = dropdownMenu.querySelectorAll('.color-option');

            colorOptions.forEach(option => {
                option.classList.remove('selected');
                if (option.classList.contains(colorClass)) {
                    option.classList.add('selected');
                }
            });

            // Prevent default anchor behavior
            event.preventDefault();
        }

        document.addEventListener('DOMContentLoaded', () => {
            const platforms = <?= json_encode(array_map(fn($p) => [
                                    'id' => $p['social_id'],
                                    'color' => $p['bg_color'] ?? 'rgba(13,110,253,1)'
                                ], $platforms)) ?>;

            platforms.forEach(platform => {
                const pickr = Pickr.create({
                    el: '#color-picker-' + platform.id,
                    theme: 'classic',
                    default: platform.color,
                    components: {
                        preview: true,
                        opacity: true,
                        hue: true,
                        interaction: {
                            input: true,
                            save: true
                        }
                    }
                });

                pickr.on('save', (color) => {
                    document.getElementById('rgba-color-' + platform.id).value = color.toRGBA().toString();
                    pickr.hide();
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr"></script>

</body>

</html>
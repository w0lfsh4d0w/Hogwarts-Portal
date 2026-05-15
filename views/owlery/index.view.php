<?php
include(base_path('views/partials/header.view.php'));
include(base_path('views/partials/nav.view.php'));

$activeUserId = $activeUser['user_id'] ?? null;

function owleryInitials(string $name): string
{
    $parts = preg_split('/\s+/', trim($name));
    $initials = '';

    foreach ($parts as $part) {
        if ($part === '') {
            continue;
        }

        $initials .= strtoupper($part[0]);
    }

    return substr($initials, 0, 2);
}

function owleryUserUrl(int $userId, string $search, bool $isNewConversation): string
{
    $url = '/owlery?user=' . $userId;

    if ($search !== '') {
        $url .= '&q=' . urlencode($search);
    }

    if ($isNewConversation) {
        $url .= '&new=1';
    }

    return $url;
}

function owleryBadgeLabel(int $count): string
{
    if ($count > 9) {
        return '+9';
    }

    return (string) $count;
}

function owlerySearchText(array $user): string
{
    $text = ($user['user_name'] ?? '') . ' ' . ($user['email'] ?? '') . ' ' . ($user['role'] ?? '');

    return strtolower(trim($text));
}
?>

<section class="owlery-page">
    <div class="owlery-shell">
        <aside class="owlery-sidebar">
            <div class="owlery-sidebar-header">
                <h2>The Owlery</h2>
                <p class="owlery-subtext">Send enchanted notes across Hogwarts.</p>
            </div>

            <div class="owlery-search">
                <div class="owlery-search-field">
                    <input type="text" name="q" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search by name or email" autocomplete="off">
                    <button type="button" class="owlery-search-clear" aria-label="Clear search">&times;</button>
                </div>
                <?php if ($isNewConversation): ?>
                    <a class="owlery-search-new" href="/owlery<?php echo $activeUserId ? '?user=' . (int) $activeUserId : ''; ?>" aria-label="Back to recent">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                <?php else: ?>
                    <a class="owlery-search-new" href="/owlery?new=1<?php echo $search !== '' ? '&q=' . urlencode($search) : ''; ?>" aria-label="New conversation">
                        <i class="fa-solid fa-plus"></i>
                    </a>
                <?php endif; ?>
            </div>

            <div class="owlery-group-list">
                <?php foreach ($roleGroups as $group): ?>
                    <?php if (empty($group['visible'])): ?>
                        <?php continue; ?>
                    <?php endif; ?>
                    <div class="owlery-group">
                        <div class="owlery-group-title"><?php echo htmlspecialchars($group['label']); ?></div>

                        <?php if (!empty($group['recent'])): ?>
                            <div class="owlery-group-subtitle">Recent</div>
                            <?php foreach ($group['recent'] as $user): ?>
                                <a class="owlery-user <?php echo ($activeUserId === (int) $user['user_id']) ? 'active' : ''; ?>" href="<?php echo owleryUserUrl((int) $user['user_id'], $search, $isNewConversation); ?>" data-search="<?php echo htmlspecialchars(owlerySearchText($user)); ?>">
                                    <span class="owlery-avatar"><?php echo owleryInitials($user['user_name']); ?></span>
                                    <div class="owlery-user-meta">
                                        <span class="owlery-user-name"><?php echo htmlspecialchars($user['user_name']); ?></span>
                                        <span class="owlery-user-role"><?php echo htmlspecialchars($user['role']); ?></span>
                                    </div>
                                    <?php if ((int) $user['unread_count'] > 0): ?>
                                        <span class="owlery-badge"><?php echo owleryBadgeLabel((int) $user['unread_count']); ?></span>
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if ($isNewConversation && !empty($group['others'])): ?>
                            <div class="owlery-group-subtitle">All</div>
                            <?php foreach ($group['others'] as $user): ?>
                                <a class="owlery-user <?php echo ($activeUserId === (int) $user['user_id']) ? 'active' : ''; ?>" href="<?php echo owleryUserUrl((int) $user['user_id'], $search, $isNewConversation); ?>" data-search="<?php echo htmlspecialchars(owlerySearchText($user)); ?>">
                                    <span class="owlery-avatar"><?php echo owleryInitials($user['user_name']); ?></span>
                                    <div class="owlery-user-meta">
                                        <span class="owlery-user-name"><?php echo htmlspecialchars($user['user_name']); ?></span>
                                        <span class="owlery-user-role"><?php echo htmlspecialchars($user['role']); ?></span>
                                    </div>
                                    <?php if ((int) $user['unread_count'] > 0): ?>
                                        <span class="owlery-badge"><?php echo owleryBadgeLabel((int) $user['unread_count']); ?></span>
                                    <?php endif; ?>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (!$isNewConversation): ?>
                <?php
                $hasAnyGroup = false;
                foreach ($roleGroups as $group) {
                    if (!empty($group['visible'])) {
                        $hasAnyGroup = true;
                        break;
                    }
                }
                ?>

                <?php if (!$hasAnyGroup): ?>
                    <div class="owlery-empty-state">
                        <i class="fa-solid fa-feather"></i>
                        <p>No conversations yet.</p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </aside>

        <main class="owlery-chat">
            <?php if ($activeUser): ?>
                <header class="owlery-chat-header">
                    <div>
                        <h3><?php echo htmlspecialchars($activeUser['user_name']); ?></h3>
                        <p class="owlery-chat-subtitle"><?php echo htmlspecialchars($activeUser['role']); ?></p>
                    </div>
                </header>

                <?php if ($owleryError): ?>
                    <div class="owlery-alert owlery-alert-error"><?php echo htmlspecialchars($owleryError); ?></div>
                <?php endif; ?>

                <div class="owlery-thread">
                    <?php if (empty($messages)): ?>
                        <div class="owlery-empty-thread">
                            <i class="fa-solid fa-feather"></i>
                            <p>No messages yet. Send the first owl.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($messages as $message): ?>
                            <?php $isMine = ((int) $message['sender_id'] === (int) $currentUser['user_id']); ?>
                            <div class="owlery-message <?php echo $isMine ? 'mine' : 'theirs'; ?>">
                                <div class="owlery-bubble">
                                    <p><?php echo nl2br(htmlspecialchars($message['message_body'])); ?></p>
                                    <span class="owlery-time"><?php echo date('M j, g:i A', strtotime($message['sent_at'])); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <form class="owlery-compose" method="POST" action="/owlery/send">
                    <input type="hidden" name="receiver_id" value="<?php echo (int) $activeUser['user_id']; ?>">
                    <textarea name="message_body" rows="2" placeholder="Write a message..."></textarea>
                    <button type="submit" class="owlery-send">
                        <i class="fa-solid fa-paper-plane"></i>
                        Send
                    </button>
                </form>
            <?php else: ?>
                <div class="owlery-empty-state">
                    <div>
                        <i class="fa-solid fa-owl"></i>
                        <h3>Select a name to start chatting.</h3>
                        <p>Choose a student, professor, or Dumbledore from the list.</p>
                    </div>
                </div>
            <?php endif; ?>
        </main>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('.owlery-compose');
        const textarea = document.querySelector('.owlery-compose textarea');
        const searchInput = document.querySelector('.owlery-search input');
        const clearButton = document.querySelector('.owlery-search-clear');

        if (!form || !textarea) {
            return;
        }

        const resizeTextarea = () => {
            textarea.style.height = 'auto';
            textarea.style.height = `${textarea.scrollHeight}px`;
        };

        resizeTextarea();

        textarea.addEventListener('input', resizeTextarea);

        textarea.addEventListener('keydown', (event) => {
            if (event.key === 'Enter' && !event.shiftKey) {
                event.preventDefault();
                form.requestSubmit();
            }
        });

        if (searchInput) {
            const filterUsers = () => {
                const query = searchInput.value.trim().toLowerCase();
                const users = Array.from(document.querySelectorAll('.owlery-user'));

                users.forEach((user) => {
                    const haystack = user.dataset.search || '';
                    const isMatch = query === '' || haystack.includes(query);
                    user.style.display = isMatch ? '' : 'none';
                });

                document.querySelectorAll('.owlery-group').forEach((group) => {
                    const hasVisible = Array.from(group.querySelectorAll('.owlery-user'))
                        .some((user) => user.style.display !== 'none');
                    group.style.display = hasVisible ? '' : 'none';

                    group.querySelectorAll('.owlery-group-subtitle').forEach((subtitle) => {
                        let sibling = subtitle.nextElementSibling;
                        let subtitleVisible = false;

                        while (sibling && !sibling.classList.contains('owlery-group-subtitle')) {
                            if (sibling.classList.contains('owlery-user') && sibling.style.display !== 'none') {
                                subtitleVisible = true;
                                break;
                            }

                            sibling = sibling.nextElementSibling;
                        }

                        subtitle.style.display = subtitleVisible ? '' : 'none';
                    });
                });

                if (clearButton) {
                    clearButton.style.display = query === '' ? 'none' : 'inline-flex';
                }
            };

            searchInput.addEventListener('input', filterUsers);
            if (clearButton) {
                clearButton.addEventListener('click', () => {
                    searchInput.value = '';
                    searchInput.focus();
                    filterUsers();
                });
            }
            filterUsers();
        }
    });
</script>

<style>
    .owlery-page {
        background: radial-gradient(circle at top, rgba(14, 26, 64, 0.95), rgba(5, 10, 24, 0.98));
        min-height: 88vh;
        padding: 32px 24px 60px;
        color: #f5f5f5;
        font-family: 'Cinzel', serif;
    }

    .owlery-shell {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 24px;
    }

    .owlery-sidebar {
        background: rgba(14, 26, 64, 0.85);
        border: 1px solid rgba(148, 107, 45, 0.5);
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        position: sticky;
        top: 20px;
        height: fit-content;
    }

    .owlery-sidebar-header h2 {
        font-size: 26px;
        margin-bottom: 4px;
        color: #ffd27d;
    }

    .owlery-subtext {
        font-family: 'Montserrat', sans-serif;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 16px;
    }

    .owlery-search {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        align-items: center;
        width: 100%;
    }

    .owlery-search-field {
        position: relative;
        flex: 1;
    }

    .owlery-search-new {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        text-decoration: none;
        background: linear-gradient(135deg, #946B2D, #d6a85a);
        color: #0e1a40;
        border: none;
        width: 44px;
        height: 44px;
        flex: 0 0 44px;
    }

    .owlery-search input {
        width: 100%;
        min-width: 0;
        border-radius: 12px;
        border: 1px solid rgba(148, 107, 45, 0.6);
        background: rgba(7, 12, 30, 0.8);
        color: #fff;
        padding: 10px 36px 10px 12px;
        font-family: 'Montserrat', sans-serif;
        font-size: 13px;
    }

    .owlery-search-clear {
        position: absolute;
        top: 50%;
        right: 10px;
        transform: translateY(-50%);
        width: 22px;
        height: 22px;
        border-radius: 50%;
        border: 1px solid rgba(148, 107, 45, 0.6);
        background: rgba(148, 107, 45, 0.25);
        color: #ffd27d;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        line-height: 1;
        cursor: pointer;
    }

    .owlery-group-title {
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 20px;
        margin-bottom: 10px;
        color: rgba(255, 210, 125, 0.8);
    }

    .owlery-group-subtitle {
        font-size: 12px;
        font-family: 'Montserrat', sans-serif;
        margin: 12px 0 6px;
        color: rgba(255, 255, 255, 0.6);
    }

    .owlery-user {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        border-radius: 14px;
        text-decoration: none;
        color: #fff;
        transition: all 0.2s ease;
        position: relative;
    }

    .owlery-user:hover {
        background: rgba(148, 107, 45, 0.2);
        transform: translateX(2px);
    }

    .owlery-user.active {
        background: rgba(148, 107, 45, 0.35);
        border: 1px solid rgba(255, 210, 125, 0.6);
    }

    .owlery-avatar {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: linear-gradient(135deg, #946B2D, #f7d08a);
        color: #0e1a40;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
    }

    .owlery-user-meta {
        display: flex;
        flex-direction: column;
    }

    .owlery-user-name {
        font-family: 'Montserrat', sans-serif;
        font-size: 14px;
        font-weight: 600;
    }

    .owlery-user-role {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.6);
    }

    .owlery-badge {
        margin-left: auto;
        background: #ffd27d;
        color: #0e1a40;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 999px;
        font-size: 11px;
    }

    .owlery-empty {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.5);
        font-family: 'Montserrat', sans-serif;
    }

    .owlery-chat {
        background: rgba(9, 16, 40, 0.9);
        border-radius: 20px;
        border: 1px solid rgba(148, 107, 45, 0.5);
        padding: 24px;
        display: flex;
        flex-direction: column;
        min-height: 560px;
    }

    .owlery-chat-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid rgba(148, 107, 45, 0.4);
        padding-bottom: 12px;
        margin-bottom: 16px;
    }

    .owlery-chat-header h3 {
        margin: 0;
        font-size: 22px;
        color: #ffd27d;
    }

    .owlery-chat-subtitle {
        font-family: 'Montserrat', sans-serif;
        font-size: 12px;
        color: rgba(255, 255, 255, 0.6);
        margin: 0;
    }

    .owlery-thread {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 12px;
        overflow-y: auto;
        padding-right: 6px;
    }

    .owlery-message {
        display: flex;
    }

    .owlery-message.mine {
        justify-content: flex-end;
    }

    .owlery-bubble {
        max-width: 70%;
        background: rgba(255, 210, 125, 0.15);
        border: 1px solid rgba(255, 210, 125, 0.3);
        border-radius: 18px;
        padding: 12px 14px;
        font-family: 'Montserrat', sans-serif;
        font-size: 13px;
        line-height: 1.5;
        position: relative;
    }

    .owlery-message.mine .owlery-bubble {
        background: rgba(148, 107, 45, 0.35);
        border-color: rgba(148, 107, 45, 0.6);
    }

    .owlery-time {
        display: block;
        font-size: 10px;
        color: rgba(255, 255, 255, 0.6);
        margin-top: 6px;
        text-align: right;
    }

    .owlery-compose {
        display: flex;
        gap: 12px;
        margin-top: 18px;
        border-top: 1px solid rgba(148, 107, 45, 0.4);
        padding-top: 16px;
    }

    .owlery-compose textarea {
        flex: 1;
        background: rgba(7, 12, 30, 0.8);
        border: 1px solid rgba(148, 107, 45, 0.6);
        border-radius: 14px;
        color: #fff;
        padding: 10px 12px;
        font-family: 'Montserrat', sans-serif;
        resize: vertical;
        min-height: 54px;
    }

    .owlery-send {
        background: linear-gradient(135deg, #946B2D, #f7d08a);
        color: #0e1a40;
        border: none;
        border-radius: 14px;
        padding: 0 20px;
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        min-height: 54px;
    }

    .owlery-empty-state,
    .owlery-empty-thread {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: rgba(255, 255, 255, 0.7);
        font-family: 'Montserrat', sans-serif;
        flex-direction: column;
        gap: 10px;
    }

    .owlery-alert {
        padding: 10px 14px;
        border-radius: 12px;
        font-family: 'Montserrat', sans-serif;
        font-size: 13px;
        margin-bottom: 12px;
    }

    .owlery-alert-error {
        background: rgba(192, 57, 43, 0.2);
        border: 1px solid rgba(192, 57, 43, 0.5);
        color: #ffd5d0;
    }

    @media (max-width: 992px) {
        .owlery-shell {
            grid-template-columns: 1fr;
        }

        .owlery-sidebar {
            position: static;
        }
    }
</style>

<?php require base_path('views/partials/footer.view.php'); ?>

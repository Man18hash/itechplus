@php
  use Illuminate\Support\Facades\Auth;

  // Are we in admin?  This drives both the AJAX URL and the initial guard check.
  $isAdmin = Auth::guard('admin')->check();
  $baseUrl = $isAdmin
    ? url('admin/messages')
    : url('messages');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Chat – {{ $cartItem->project->project_name }}</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
</head>
<body>

  <nav class="navbar navbar-light bg-light px-3">
    <button onclick="window.history.back();" class="btn btn-secondary">
      &larr; Back
    </button>
  </nav>

  <div
    id="chat-container"
    data-base-url="{{ $baseUrl }}"
    data-cart-id="{{ $cartItem->id }}"
    class="container py-4"
  >
    <h4>Chat about {{ $cartItem->project->project_name }}</h4>
    <div
      id="messages"
      class="border rounded"
      style="height: 300px; overflow-y: auto; padding: 1rem;"
    ></div>

    <form id="chat-form" enctype="multipart/form-data" class="mt-3">
      @csrf
      <div class="mb-2">
        <textarea
          name="message"
          class="form-control"
          rows="2"
          placeholder="Type your message…"
        ></textarea>
      </div>
      <div class="mb-2">
        <input type="file" name="attachment" class="form-control">
      </div>
      <button class="btn btn-primary">Send</button>
    </form>
  </div>

  <script>
    const container   = document.getElementById('chat-container');
    const baseUrl     = container.dataset.baseUrl;
    const cartId      = container.dataset.cartId;
    const messagesDiv = document.getElementById('messages');
    const form        = document.getElementById('chat-form');
    const csrfToken   = document.querySelector('meta[name="csrf-token"]').content;

    function loadMessages() {
      fetch(`${baseUrl}/${cartId}/messages`)
        .then(res => {
          if (!res.ok) throw new Error(`HTTP ${res.status}`);
          return res.json();
        })
        .then(msgs => {
          messagesDiv.innerHTML = '';
          msgs.forEach(m => {
            // Label “Admin” for admin‐sent messages; otherwise the user's first name
            const sender = m.from_admin
              ? 'Admin'
              : (m.user?.first_name || 'You');

            const html = `
              <div class="mb-2">
                <strong>${sender}:</strong>
                <p class="mb-1">${m.message || ''}</p>
                ${m.attachment_path
                  ? ((/\.(jpe?g|png|gif)$/i).test(m.attachment_path)
                      ? `<img src="/storage/${m.attachment_path}" style="max-width:100px; display:block;">`
                      : `<a href="/storage/${m.attachment_path}" target="_blank">Download file</a>`
                    )
                  : ''
                }
                <div><small class="text-muted">${new Date(m.created_at).toLocaleString()}</small></div>
                <hr>
              </div>`;
            messagesDiv.insertAdjacentHTML('beforeend', html);
          });
          messagesDiv.scrollTop = messagesDiv.scrollHeight;
        })
        .catch(console.error);
    }

    form.addEventListener('submit', e => {
      e.preventDefault();
      const fd = new FormData(form);

      fetch(`${baseUrl}/${cartId}/messages`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken },
        body: fd
      })
      .then(res => {
        if (!res.ok) throw new Error(`HTTP ${res.status}`);
        form.reset();
        loadMessages();
      })
      .catch(console.error);
    });

    // Poll for new messages every 3 seconds
    setInterval(loadMessages, 3000);
    loadMessages();
  </script>

</body>
</html>

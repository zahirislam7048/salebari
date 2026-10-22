<?php
require __DIR__ . '/../app/bootstrap.php';
require __DIR__ . '/_chrome.php';

if (!installed()) {
    redirect('install.php');
}
require_admin();

$statuses = order_statuses();
$editId   = input_int('edit', 0) ?: null;
$editing  = $editId ? row('SELECT * FROM orders WHERE id = ?', [$editId]) : null;

if (is_post()) {
    csrf_check();
    $action = input('action');

    if ($action === 'create' || $action === 'update') {
        $id    = input_int('id', 0);
        $phone = normalize_bd_phone((string) input('phone'));
        $item  = (string) input('item_title');
        $data  = [
            'customer_name'  => input('customer_name') ?: null,
            'phone'          => $phone,
            'item_title'     => $item,
            'product_id'     => input_int('product_id', 0) ?: null,
            'stall_id'       => input_int('stall_id', 0) ?: null,
            'quantity'       => max(1, input_int('quantity', 1)),
            'amount_display' => input('amount_display') ?: null,
            'address'        => input('address') ?: null,
        ];
        if (!$phone) {
            flash('error', 'Enter a valid Bangladesh mobile number (e.g. 01712345678) — customers track their order with it.');
            redirect('admin/orders.php', $id ? ['edit' => $id] : []);
        }
        if ($item === '') {
            flash('error', 'Enter what was ordered.');
            redirect('admin/orders.php', $id ? ['edit' => $id] : []);
        }

        if ($action === 'update' && $id) {
            $data['updated_at'] = now();
            update('orders', $data, 'id = ?', [$id]);
            flash('success', 'Order updated.');
            redirect('admin/orders.php', ['edit' => $id]);
        }

        $status = array_key_exists((string) input('status'), $statuses) ? (string) input('status') : 'placed';
        $data['status']     = $status;
        $data['created_at'] = now();
        $data['updated_at'] = now();
        $newId = insert('orders', $data);
        insert('order_events', ['order_id' => $newId, 'status' => $status, 'note' => input('note') ?: null, 'created_at' => now()]);
        update('orders', ['status_note' => input('note') ?: null], 'id = ?', [$newId]);
        flash('success', 'Order ' . order_number($newId) . ' created.');
        redirect('admin/orders.php', ['edit' => $newId]);
    }

    if ($action === 'status') {
        $id     = input_int('id', 0);
        $status = (string) input('status');
        if ($id && array_key_exists($status, $statuses) && row('SELECT id FROM orders WHERE id = ?', [$id])) {
            order_set_status($id, $status, input('note') ?: null);
            flash('success', 'Status updated to "' . $statuses[$status][0] . '". The customer sees it when they track the order.');
        }
        redirect('admin/orders.php', ['edit' => $id]);
    }

    if ($action === 'delete') {
        $id = input_int('id', 0);
        delete_from('order_events', 'order_id = ?', [$id]);
        delete_from('orders', 'id = ?', [$id]);
        flash('success', 'Order deleted.');
        redirect('admin/orders.php');
    }
}

$filter = (string) input('status_filter', '');
$where  = array_key_exists($filter, $statuses) ? 'WHERE o.status = ' . db()->quote($filter) : '';
$rows   = rows(
    "SELECT o.*, s.name AS stall_name FROM orders o LEFT JOIN stalls s ON s.id = o.stall_id $where ORDER BY o.id DESC LIMIT 200"
);
$events = $editing ? rows('SELECT * FROM order_events WHERE order_id = ? ORDER BY id DESC', [$editing['id']]) : [];
$products = rows("SELECT id, title_en FROM products WHERE status = 'active' ORDER BY id DESC LIMIT 300");
$stalls   = rows("SELECT id, name FROM stalls WHERE status = 'active' ORDER BY name LIMIT 500");

admin_header('Orders');
?>
<div class="admin-card">
  <p class="muted" style="margin-top:0">Orders you enter here can be tracked by the customer on the public <a href="<?= e(url('track-order/')) ?>" target="_blank">Track an order</a> page, using only their mobile number. Update the status as the order moves along.</p>
</div>

<div class="admin-card">
  <h3 style="margin-top:0"><?= $editing ? 'Order ' . e(order_number((int) $editing['id'])) : 'Add an order' ?></h3>
  <form method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="<?= $editing ? 'update' : 'create' ?>">
    <input type="hidden" name="id" value="<?= e((string) ($editing['id'] ?? 0)) ?>">
    <label class="admin-field"><span>Customer name</span>
      <input type="text" name="customer_name" value="<?= e($editing['customer_name'] ?? '') ?>"></label>
    <label class="admin-field"><span>Customer mobile number * (this is what they use to track the order)</span>
      <input type="text" name="phone" required placeholder="01712345678" value="<?= e($editing['phone'] ?? '') ?>"></label>
    <label class="admin-field"><span>What was ordered *</span>
      <input type="text" name="item_title" required value="<?= e($editing['item_title'] ?? '') ?>"></label>
    <label class="admin-field"><span>Linked product (optional)</span>
      <select name="product_id"><option value="">—</option>
        <?php foreach ($products as $p): ?><option value="<?= (int) $p['id'] ?>" <?= (int) ($editing['product_id'] ?? 0) === (int) $p['id'] ? 'selected' : '' ?>><?= e($p['title_en']) ?></option><?php endforeach; ?>
      </select></label>
    <label class="admin-field"><span>Seller / stall (optional)</span>
      <select name="stall_id"><option value="">—</option>
        <?php foreach ($stalls as $s): ?><option value="<?= (int) $s['id'] ?>" <?= (int) ($editing['stall_id'] ?? 0) === (int) $s['id'] ? 'selected' : '' ?>><?= e($s['name']) ?></option><?php endforeach; ?>
      </select></label>
    <label class="admin-field"><span>Quantity</span>
      <input type="number" name="quantity" min="1" value="<?= e((string) ($editing['quantity'] ?? 1)) ?>"></label>
    <label class="admin-field"><span>Amount (for your records, not shown to the customer)</span>
      <input type="text" name="amount_display" value="<?= e($editing['amount_display'] ?? '') ?>"></label>
    <label class="admin-field"><span>Delivery address (for your records, not shown to the customer)</span>
      <input type="text" name="address" value="<?= e($editing['address'] ?? '') ?>"></label>
    <?php if (!$editing): ?>
      <label class="admin-field"><span>Starting status</span>
        <select name="status"><?php foreach ($statuses as $k => $st): ?><option value="<?= e($k) ?>"><?= e($st[2] . ' ' . $st[0]) ?></option><?php endforeach; ?></select></label>
      <label class="admin-field"><span>Note shown to the customer (optional)</span>
        <input type="text" name="note" maxlength="255"></label>
    <?php endif; ?>
    <button class="admin-btn admin-btn-primary" type="submit"><?= $editing ? 'Save details' : 'Add order' ?></button>
    <?php if ($editing): ?><a class="admin-btn admin-btn-ghost" href="<?= e(url('admin/orders.php')) ?>">Close</a><?php endif; ?>
  </form>
</div>

<?php if ($editing): $cur = $statuses[$editing['status']] ?? $statuses['placed']; ?>
<div class="admin-card">
  <h3 style="margin-top:0">Update status</h3>
  <p class="muted">Now: <strong><?= e($cur[2] . ' ' . $cur[0]) ?></strong></p>
  <form method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="action" value="status">
    <input type="hidden" name="id" value="<?= (int) $editing['id'] ?>">
    <label class="admin-field"><span>New status</span>
      <select name="status"><?php foreach ($statuses as $k => $st): ?><option value="<?= e($k) ?>" <?= $editing['status'] === $k ? 'selected' : '' ?>><?= e($st[2] . ' ' . $st[0]) ?></option><?php endforeach; ?></select></label>
    <label class="admin-field"><span>Note shown to the customer (optional — e.g. courier name and tracking number)</span>
      <input type="text" name="note" maxlength="255"></label>
    <button class="admin-btn admin-btn-primary" type="submit">Update status</button>
    <?php
      $wa = '88' . $editing['phone'];
      $msg = 'Hi' . ($editing['customer_name'] ? ' ' . $editing['customer_name'] : '') . ', update on your SaleBari order ' . order_number((int) $editing['id']) . ' (' . $editing['item_title'] . '): ' . $cur[0] . '. ' . $cur[3] . ' Track it any time: ' . (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'salebari.com') . url('track-order/');
    ?>
    <a class="admin-btn admin-btn-ghost" target="_blank" rel="noopener" href="https://wa.me/<?= e($wa) ?>?text=<?= urlencode($msg) ?>">Message customer on WhatsApp</a>
  </form>

  <h4>History</h4>
  <table class="admin-table">
    <thead><tr><th>When</th><th>Status</th><th>Note</th></tr></thead>
    <tbody>
      <?php foreach ($events as $ev): $es = $statuses[$ev['status']] ?? ['', '', '', '']; ?>
        <tr><td><?= e($ev['created_at']) ?></td><td><?= e($es[2] . ' ' . $es[0]) ?></td><td><?= e($ev['note'] ?? '') ?></td></tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <form method="post" onsubmit="return confirm('Delete this order?');" style="margin-top:14px">
    <?= csrf_field() ?><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= (int) $editing['id'] ?>">
    <button class="admin-btn admin-btn-danger admin-btn-sm" type="submit">Delete order</button>
  </form>
</div>
<?php endif; ?>

<div class="admin-card">
  <div class="admin-toolbar">
    <strong><?= count($rows) ?></strong><span class="muted">orders</span>
    <form method="get" style="margin-left:auto"><select name="status_filter" onchange="this.form.submit()">
      <option value="">All statuses</option>
      <?php foreach ($statuses as $k => $st): ?><option value="<?= e($k) ?>" <?= $filter === $k ? 'selected' : '' ?>><?= e($st[0]) ?></option><?php endforeach; ?>
    </select></form>
  </div>
  <div class="admin-table-wrap">
    <table class="admin-table">
      <thead><tr><th>Order</th><th>Customer</th><th>Phone</th><th>Item</th><th>Seller</th><th>Status</th><th>Updated</th><th></th></tr></thead>
      <tbody>
        <?php if (!$rows): ?><tr><td colspan="8" class="muted">No orders yet.</td></tr><?php endif; ?>
        <?php foreach ($rows as $r): $st = $statuses[$r['status']] ?? $statuses['placed']; ?>
          <tr>
            <td><strong><?= e(order_number((int) $r['id'])) ?></strong></td>
            <td><?= e($r['customer_name'] ?? '—') ?></td>
            <td><?= e($r['phone']) ?></td>
            <td><?= e($r['item_title']) ?><?= (int) $r['quantity'] > 1 ? ' × ' . (int) $r['quantity'] : '' ?></td>
            <td><?= e($r['stall_name'] ?? '—') ?></td>
            <td><span class="admin-badge admin-badge-<?= in_array($r['status'], ['delivered', 'on_the_way'], true) ? 'yes' : 'no' ?>"><?= e($st[2] . ' ' . $st[0]) ?></span></td>
            <td><?= e(substr((string) $r['updated_at'], 0, 16)) ?></td>
            <td class="admin-row-actions"><a class="admin-btn admin-btn-ghost admin-btn-sm" href="<?= e(url('admin/orders.php', ['edit' => $r['id']])) ?>">Open</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php
admin_footer();

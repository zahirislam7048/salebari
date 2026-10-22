<?php
/* Categories added after the first release (Travels, Jobs). One definition, used both by the
   installer for new sites and by a one-time update for sites that are already live. */

/** key => [parent key or null, English name, Bangla name, icon] — parents are listed before their children. */
function extra_category_definitions(): array
{
    return [
        'travels'            => [null,      'Travels',                    'ভ্রমণ',                       '✈️'],
        'airTicket'          => ['travels', 'Air Ticket',                 'এয়ার টিকেট',                  '✈️'],
        'busTicket'          => ['travels', 'Bus Ticket',                 'বাস টিকেট',                   '🚌'],
        'tourPackage'        => ['travels', 'Tour Package',               'ট্যুর প্যাকেজ',               '🧳'],
        'umrahPackage'       => ['travels', 'Umrah Package',              'ওমরাহ প্যাকেজ',               '🕋'],
        'hajjPackage'        => ['travels', 'Hajj Package',               'হজ্জ প্যাকেজ',                '🕌'],
        'hotelBooking'       => ['travels', 'Hotel Booking',              'হোটেল বুকিং',                 '🏨'],
        'visaProcessing'     => ['travels', 'Visa Processing',            'ভিসা প্রসেসিং',               '🛂'],
        'doctorAppointment'  => ['travels', 'Doctor Appointment',         'ডাক্তার অ্যাপয়েন্টমেন্ট',     '🩺'],
        'indianDoctorAppointment' => ['doctorAppointment', 'Indian Doctor Appointment', 'ভারতীয় ডাক্তার অ্যাপয়েন্টমেন্ট', '🩺'],
        'trainTicket'        => ['travels', 'Train Ticket',               'ট্রেন টিকেট',                 '🚆'],
        'saintMartinShipTicket' => ['travels', 'Saint Martin Ship Ticket', 'সেন্ট মার্টিন শিপ টিকেট',    '🚢'],
        'jobs'               => [null,      'Jobs',                       'চাকরি',                        '💼'],
    ];
}

/** Insert any of the above that are missing. Safe to run more than once. */
function add_extra_categories(): void
{
    $ids = [];
    foreach (extra_category_definitions() as $key => [$parentKey, $nameEn, $nameBn, $icon]) {
        $existing = row('SELECT id FROM categories WHERE slug = ?', [$key]);
        if ($existing) {
            $ids[$key] = (int) $existing['id'];
            continue;
        }
        $parentId = $parentKey ? ($ids[$parentKey] ?? null) : null;
        if ($parentKey && !$parentId) {
            continue;
        }
        $level = $parentKey ? ((int) scalar('SELECT level FROM categories WHERE id = ?', [$parentId]) + 1) : 1;
        $order = (int) scalar('SELECT COUNT(*) FROM categories WHERE ' . ($parentId ? 'parent_id = ?' : 'parent_id IS NULL'), $parentId ? [$parentId] : []);
        $ids[$key] = insert('categories', [
            'parent_id'      => $parentId,
            'level'          => $level,
            'slug'           => $key,
            'name_en'        => $nameEn,
            'name_bn'        => $nameBn,
            'icon'           => $icon,
            'count_label_en' => null,
            'count_label_bn' => null,
            'featured'       => $level === 1 ? 1 : 0,
            'sort_order'     => $order,
            'created_at'     => now(),
        ]);
    }
}

/** Once, on sites that were installed before these categories existed. */
function ensure_extra_categories(): void
{
    try {
        if (scalar("SELECT COUNT(*) FROM settings WHERE k = 'extra_cats_v1'")) {
            return;
        }
        if ((int) scalar('SELECT COUNT(*) FROM categories') === 0) {
            return; // fresh install: the seeder adds them
        }
        add_extra_categories();
        insert('settings', ['k' => 'extra_cats_v1', 'v_en' => '1', 'v_bn' => null]);
    } catch (Throwable $e) {
        error_log('SaleBari ensure_extra_categories: ' . $e->getMessage());
    }
}

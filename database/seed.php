<?php

/*Seeding user*/

echo 'Seeding User table' . PHP_EOL;
$password = password_hash('ch4nge_th1s', PASSWORD_DEFAULT);
$users = [
    ['email' => 'samrequena1510@gmail.com', 'password' => $password],
    ['email' => 'sam@hepl.be', 'password' => $password],
];
$insert_user_in_users_table_sql = 'INSERT INTO users (email, password) VALUES (:email, :password)';
$insert_user_in_users_table_stmt = $db->prepare($insert_user_in_users_table_sql);
foreach ($users as $user) {
    $insert_user_in_users_table_stmt->bindValue('email', $user['email']);
    $insert_user_in_users_table_stmt->bindValue('password', $user['password']);
    $insert_user_in_users_table_stmt->execute();
}
$count_users = count($users);
echo "User table seeded with {$count_users} users" . PHP_EOL;

// Seed Jiri tables

echo 'Seeding Jiri table' . PHP_EOL;
$jiris = [
    ['name' => 'Projets Web 2024', 'starting_at' => '2024-01-19 08:30:00', 'user_id' => 1],
    ['name' => 'Design Web 2024', 'starting_at' => '2024-06-19 08:30:00', 'user_id' => 2],
    ['name' => 'Design Web 2022', 'starting_at' => '2022-06-19 08:30:00', 'user_id' => 2],
    ['name' => 'Design Web 2021', 'starting_at' => '2021-06-19 08:30:00', 'user_id' => 2],
    ['name' => 'Projets Web 2025', 'starting_at' => '2025-01-19 08:30:00', 'user_id' => 1],
    ['name' => 'Projets Web 2026', 'starting_at' => '2026-01-19 08:30:00', 'user_id' => 1],
    ['name' => 'Projets Web 2027', 'starting_at' => '2027-01-19 08:30:00', 'user_id' => 1],
    ['name' => 'Design Web 2023', 'starting_at' => '2023-06-19 08:30:00', 'user_id' => 1],
];
$insert_jiri_in_jiris_table_sql = 'INSERT INTO jiris (name, starting_at, user_id) VALUES (:name, :starting_at, :user_id)';
$insert_jiri_in_jiris_table_stmt = $db->prepare($insert_jiri_in_jiris_table_sql);
foreach ($jiris as $jiri) {
    $insert_jiri_in_jiris_table_stmt->bindValue('name', $jiri['name']);
    $insert_jiri_in_jiris_table_stmt->bindValue('starting_at', $jiri['starting_at']);
    $insert_jiri_in_jiris_table_stmt->bindValue('user_id', $jiri['user_id']);
    $insert_jiri_in_jiris_table_stmt->execute();
}
$count_jiris = count($jiris);
echo "Jiri table seeded with {$count_jiris} jiris" . PHP_EOL;

// Seed Contatc tables

echo 'Seeding Contact table' . PHP_EOL;
$contacts = [
    ['name' => 'Vilain Dominique', 'email' => 'dominic@gmail.com', 'user_id' => 1],
    ['name' => 'Requena Frédéric', 'email' => 'frederic@gmail.com', 'user_id' => 2],
    ['name' => 'Briol Alexandre', 'email' => 'alex@gmail.com', 'user_id' => 2],
];
$insert_contact_in_contacts_table_sql = 'INSERT INTO contacts (name, email, user_id) VALUES (:name, :email, :user_id)';
$insert_contact_in_contacts_table_stmt = $db->prepare($insert_contact_in_contacts_table_sql);
foreach ($contacts as $contact) {
    $insert_contact_in_contacts_table_stmt->bindValue('name', $contact['name']);
    $insert_contact_in_contacts_table_stmt->bindValue('email', $contact['email']);
    $insert_contact_in_contacts_table_stmt->bindValue('user_id', $contact['user_id']);
    $insert_contact_in_contacts_table_stmt->execute();
}
$count_contacts = count($contacts);
echo "Contact table seeded with {$count_contacts} contacts" . PHP_EOL;


// Seed Attendances tables

echo 'Seeding Attendances table' . PHP_EOL;
$attendances = [
    ['contact_id' => '1' , 'jiri_id' => '1'],
];
$insert_attendance_in_attendances_table_sql = 'INSERT INTO attendances (contact_id, jiri_id) VALUES (:contact_id, :jiri_id)';
$insert_attendance_in_attendances_table_stmt = $db->prepare($insert_attendance_in_attendances_table_sql);
foreach ($attendances as $attendance) {
    $insert_attendance_in_attendances_table_stmt->bindValue('contact_id', $attendance['contact_id']);
    $insert_attendance_in_attendances_table_stmt->bindValue('jiri_id', $attendance['jiri_id']);
    $insert_attendance_in_attendances_table_stmt->execute();
}
$count_attendances = count($attendances);
echo "Attendances table seeded with {$count_attendances} attendances" . PHP_EOL;


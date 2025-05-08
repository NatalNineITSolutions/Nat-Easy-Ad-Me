<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Generate a unique partner ID.
     *
     * @return string
     */
    protected function generatePartnerId()
    {
        do {
            $year = now()->format('Y');
            $month = now()->format('n');
            $randomDigits = rand(1000, 99999);
            $partnerId = 'GL' . $year . $month . $randomDigits;
        } while (User::where('partner_id', $partnerId)->exists());

        return $partnerId;
    }

    /**
     * Generate a partner name based on first name.
     *
     * @param string $firstName
     * @return string
     */
    protected function generatePartnerName(string $firstName)
    {
        return 'EASYADME-' . strtoupper($firstName);
    }

    public function run(): void
    {
        // Disable foreign key checks for truncation
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Create A (main sponsor user)
        $partnerIdA = $this->generatePartnerId();
        $partnerNameA = $this->generatePartnerName('Alex');

        $userA = User::create([
            'first_name'   => 'Alex',
            'last_name'    => 'Morgan',
            'email'        => 'alex.morgan@example.com',
            'username'     => 'alex_morgan',
            'phone'        => '9000000000',
            'country_id'   => '91',
            'password'     => Hash::make('password123'),
            'parent_id'    => null,
            'sponsor_id'   => null,
            'position'     => null,
            'gender'       => 'male',
            'dob'          => '1990-01-01',
            'partner_id'   => $partnerIdA,
            'partner_name' => $partnerNameA,
            'otp_verified' => 1,
        ]);

        // Self-sponsor
        $userA->update(['sponsor_id' => $userA->id]);

        // Create B under A
        $partnerIdB = $this->generatePartnerId();
        $partnerNameB = $this->generatePartnerName('Ben');

        $userB = User::create([
            'first_name'   => 'Ben',
            'last_name'    => 'Turner',
            'email'        => 'ben.turner@example.com',
            'username'     => 'ben_turner',
            'phone'        => '9000000001',
            'country_id'   => '91',
            'password'     => Hash::make('password123'),
            'parent_id'    => $userA->id,
            'sponsor_id'   => $userA->id,
            'position'     => 'left',
            'gender'       => 'male',
            'dob'          => '1991-02-02',
            'partner_id'   => $partnerIdB,
            'partner_name' => $partnerNameB,
            'otp_verified' => 1,
        ]);

        // Create C under A
        $partnerIdC = $this->generatePartnerId();
        $partnerNameC = $this->generatePartnerName('Cathy');

        $userC = User::create([
            'first_name'   => 'Cathy',
            'last_name'    => 'Smith',
            'email'        => 'cathy.smith@example.com',
            'username'     => 'cathy_smith',
            'phone'        => '9000000002',
            'country_id'   => '91',
            'password'     => Hash::make('password123'),
            'parent_id'    => $userA->id,
            'sponsor_id'   => $userA->id,
            'position'     => 'right',
            'gender'       => 'female',
            'dob'          => '1992-03-03',
            'partner_id'   => $partnerIdC,
            'partner_name' => $partnerNameC,
            'otp_verified' => 1,
        ]);

        // Create E under B
        $partnerIdE = $this->generatePartnerId();
        $partnerNameE = $this->generatePartnerName('Evan');

        $userE = User::create([
            'first_name'   => 'Evan',
            'last_name'    => 'Wells',
            'email'        => 'evan.wells@example.com',
            'username'     => 'evan_wells',
            'phone'        => '9000000003',
            'country_id'   => '91',
            'password'     => Hash::make('password123'),
            'parent_id'    => $userB->id,
            'sponsor_id'   => $userA->id,
            'position'     => 'left',
            'gender'       => 'male',
            'dob'          => '1993-04-04',
            'partner_id'   => $partnerIdE,
            'partner_name' => $partnerNameE,
            'otp_verified' => 1,
        ]);

        // Create F under B
        $partnerIdF = $this->generatePartnerId();
        $partnerNameF = $this->generatePartnerName('Fiona');

        $userF = User::create([
            'first_name'   => 'Fiona',
            'last_name'    => 'Brooks',
            'email'        => 'fiona.brooks@example.com',
            'username'     => 'fiona_brooks',
            'phone'        => '9000000004',
            'country_id'   => '91',
            'password'     => Hash::make('password123'),
            'parent_id'    => $userB->id,
            'sponsor_id'   => $userA->id,
            'position'     => 'right',
            'gender'       => 'female',
            'dob'          => '1994-05-05',
            'partner_id'   => $partnerIdF,
            'partner_name' => $partnerNameF,
            'otp_verified' => 1,
        ]);

        // Create G under C
        $partnerIdG = $this->generatePartnerId();
        $partnerNameG = $this->generatePartnerName('George');

        $userG = User::create([
            'first_name'   => 'George',
            'last_name'    => 'Hill',
            'email'        => 'george.hill@example.com',
            'username'     => 'george_hill',
            'phone'        => '9000000005',
            'country_id'   => '91',
            'password'     => Hash::make('password123'),
            'parent_id'    => $userC->id,
            'sponsor_id'   => $userA->id,
            'position'     => 'left',
            'gender'       => 'male',
            'dob'          => '1995-06-06',
            'partner_id'   => $partnerIdG,
            'partner_name' => $partnerNameG,
            'otp_verified' => 1,
        ]);

        // Create H under C
        $partnerIdH = $this->generatePartnerId();
        $partnerNameH = $this->generatePartnerName('Hannah');

        $userH = User::create([
            'first_name'   => 'Hannah',
            'last_name'    => 'Lee',
            'email'        => 'hannah.lee@example.com',
            'username'     => 'hannah_lee',
            'phone'        => '9000000006',
            'country_id'   => '91',
            'password'     => Hash::make('password123'),
            'parent_id'    => $userC->id,
            'sponsor_id'   => $userA->id,
            'position'     => 'right',
            'gender'       => 'female',
            'dob'          => '1996-07-07',
            'partner_id'   => $partnerIdH,
            'partner_name' => $partnerNameH,
            'otp_verified' => 1,
        ]);
    }
}

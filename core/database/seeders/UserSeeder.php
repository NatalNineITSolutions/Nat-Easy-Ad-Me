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
        $userA->update(['sponsor_id' => null]);

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

        // Create I and J under E
        $partnerIdI = $this->generatePartnerId();
        $partnerNameI = $this->generatePartnerName('Irene');
        $userI = User::create([
            'first_name'   => 'Irene',
            'last_name'    => 'Adams',
            'email'        => 'irene.adams@example.com',
            'username'     => 'irene_adams',
            'phone'        => '9000000007',
            'country_id'   => '91',
            'password'     => Hash::make('password123'),
            'parent_id'    => $userE->id,
            'sponsor_id'   => $userA->id,
            'position'     => 'left',
            'gender'       => 'female',
            'dob'          => '1997-08-08',
            'partner_id'   => $partnerIdI,
            'partner_name' => $partnerNameI,
            'otp_verified' => 1,
        ]);

        $partnerIdJ = $this->generatePartnerId();
        $partnerNameJ = $this->generatePartnerName('Jack');
        $userJ = User::create([
            'first_name'   => 'Jack',
            'last_name'    => 'Martin',
            'email'        => 'jack.martin@example.com',
            'username'     => 'jack_martin',
            'phone'        => '9000000008',
            'country_id'   => '91',
            'password'     => Hash::make('password123'),
            'parent_id'    => $userE->id,
            'sponsor_id'   => $userA->id,
            'position'     => 'right',
            'gender'       => 'male',
            'dob'          => '1998-09-09',
            'partner_id'   => $partnerIdJ,
            'partner_name' => $partnerNameJ,
            'otp_verified' => 1,
        ]);

        // Create K and L under F
        $partnerIdK = $this->generatePartnerId();
        $partnerNameK = $this->generatePartnerName('Karen');
        $userK = User::create([
            'first_name'   => 'Karen',
            'last_name'    => 'O\'Neil',
            'email'        => 'karen.oneil@example.com',
            'username'     => 'karen_oneil',
            'phone'        => '9000000009',
            'country_id'   => '91',
            'password'     => Hash::make('password123'),
            'parent_id'    => $userF->id,
            'sponsor_id'   => $userA->id,
            'position'     => 'left',
            'gender'       => 'female',
            'dob'          => '1999-10-10',
            'partner_id'   => $partnerIdK,
            'partner_name' => $partnerNameK,
            'otp_verified' => 1,
        ]);

        $partnerIdL = $this->generatePartnerId();
        $partnerNameL = $this->generatePartnerName('Leo');
        $userL = User::create([
            'first_name'   => 'Leo',
            'last_name'    => 'Patel',
            'email'        => 'leo.patel@example.com',
            'username'     => 'leo_patel',
            'phone'        => '9000000010',
            'country_id'   => '91',
            'password'     => Hash::make('password123'),
            'parent_id'    => $userF->id,
            'sponsor_id'   => $userA->id,
            'position'     => 'right',
            'gender'       => 'male',
            'dob'          => '2000-11-11',
            'partner_id'   => $partnerIdL,
            'partner_name' => $partnerNameL,
            'otp_verified' => 1,
        ]);

        // Create M and N under G
        $partnerIdM = $this->generatePartnerId();
        $partnerNameM = $this->generatePartnerName('Maya');
        $userM = User::create([
            'first_name'   => 'Maya',
            'last_name'    => 'Sharma',
            'email'        => 'maya.sharma@example.com',
            'username'     => 'maya_sharma',
            'phone'        => '9000000011',
            'country_id'   => '91',
            'password'     => Hash::make('password123'),
            'parent_id'    => $userG->id,
            'sponsor_id'   => $userA->id,
            'position'     => 'left',
            'gender'       => 'female',
            'dob'          => '2001-12-12',
            'partner_id'   => $partnerIdM,
            'partner_name' => $partnerNameM,
            'otp_verified' => 1,
        ]);

        $partnerIdN = $this->generatePartnerId();
        $partnerNameN = $this->generatePartnerName('Noah');
        $userN = User::create([
            'first_name'   => 'Noah',
            'last_name'    => 'Desai',
            'email'        => 'noah.desai@example.com',
            'username'     => 'noah_desai',
            'phone'        => '9000000012',
            'country_id'   => '91',
            'password'     => Hash::make('password123'),
            'parent_id'    => $userG->id,
            'sponsor_id'   => $userA->id,
            'position'     => 'right',
            'gender'       => 'male',
            'dob'          => '2002-01-13',
            'partner_id'   => $partnerIdN,
            'partner_name' => $partnerNameN,
            'otp_verified' => 1,
        ]);

        // Create O and P under H
        $partnerIdO = $this->generatePartnerId();
        $partnerNameO = $this->generatePartnerName('Olivia');
        $userO = User::create([
            'first_name'   => 'Olivia',
            'last_name'    => 'Khan',
            'email'        => 'olivia.khan@example.com',
            'username'     => 'olivia_khan',
            'phone'        => '9000000013',
            'country_id'   => '91',
            'password'     => Hash::make('password123'),
            'parent_id'    => $userH->id,
            'sponsor_id'   => $userA->id,
            'position'     => 'left',
            'gender'       => 'female',
            'dob'          => '2003-02-14',
            'partner_id'   => $partnerIdO,
            'partner_name' => $partnerNameO,
            'otp_verified' => 1,
        ]);

        $partnerIdP = $this->generatePartnerId();
        $partnerNameP = $this->generatePartnerName('Paul');
        $userP = User::create([
            'first_name'   => 'Paul',
            'last_name'    => 'Verma',
            'email'        => 'paul.verma@example.com',
            'username'     => 'paul_verma',
            'phone'        => '9000000014',
            'country_id'   => '91',
            'password'     => Hash::make('password123'),
            'parent_id'    => $userH->id,
            'sponsor_id'   => $userA->id,
            'position'     => 'right',
            'gender'       => 'male',
            'dob'          => '2004-03-15',
            'partner_id'   => $partnerIdP,
            'partner_name' => $partnerNameP,
            'otp_verified' => 1,
        ]);
    }
}

<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [
            ['NOPRIZAL, M. Pd', '197711092006041006', 'III.d', 'KEPALA MADRASAH'],
            ['FITRA DONI GEMINTARYA, S.A.P', '197506142005011006', 'III.a', 'KAUR TU MADRASAH'],
            ['RIZA PUSPITA SARI, S. Pd', '197607142006042019', 'IV.b', 'WAKA. KURIKULUM'],
            ['ABRIS TRI PUTRA, S.Si', '199202152019031017', 'III.b', 'WAKA. SISWA'],
            ['ADRISMAN, S. Pd.I', '197705312007101003', 'III.c', 'WAKA. SARPRAS'],
            ['RAHMATULLAH, S. Pd, M.Pd', '198004262005011004', 'IV.b', 'WAKA. HUMAS'],
            ['FIFIAN RUBIANTI N, S.Ag', '197602182009012006', 'III.d', 'BENDAHARA'],
            ['HERLINA,S.Pd', '197003141997032003', 'IV.b', 'GURU'],
            ['YUSMAINI, S.Pd', '197005081999032002', 'IV.b', 'GURU'],
            ['Dra. HENDRAYENTI', '196708211997032002', 'IV.b', 'GURU'],
            ['HARNEWI B, S.Pd', '197105071996032002', 'IV.b', 'GURU'],
            ['GUSMALINDA, S. Pd. BIO', '197008141994032001', 'IV.b', 'GURU'],
            ['TUTI HARYATI, S. Pd', '196910121998032003', 'IV.b', 'GURU'],
            ['NURHAPIZAH, S. Pd', '196611201992032003', 'IV.b', 'GURU'],
            ['GEMA WIYARTI, M.Pd', '196902151997032002', 'IV.b', 'GURU'],
            ['MARNIETY, S. Pd', '197106042005012005', 'IV.b', 'GURU'],
            ['DESNIATI, M.Pd', '197507302007012013', 'IV.a', 'GURU'],
            ['FITRI YENTI, S.Pd', '197111222006042005', 'IV.a', 'GURU'],
            ['SITI AIDA, S. Pd', '196802041993032004', 'IV.a', 'GURU'],
            ['EVINIARTI, S. Ag', '196912031993032003', 'IV.a', 'GURU'],
            ['ZONDRA, S. Pd', '197403262005011003', 'IV.a', 'GURU'],
            ['AFRINALITA, S. Pd', '196904062006042001', 'IV.a', 'GURU'],
            ['SRI MULYANI , S.Pd', '197207032005012002', 'IV.a', 'GURU'],
            ['HARTATI, S. Pd', '197409162000122001', 'IV.a', 'GURU'],
            ['FIDDIA WATY, S. Pd', '197711122005012009', 'IV.a', 'GURU'],
            ['FEBRESTI, S. Pd', '197302121998032001', 'IV.a', 'GURU'],
            ['USWATUN HASANAH, S.Pd.I M. Pd', '198412182009012013', 'III.d', 'GURU'],
            ['VIVI YASTIKA SARI, S.Pd', '196904182005012007', 'III.d', 'GURU'],
            ['MARIANIS, S. Ag', '197103222007012014', 'III.d', 'GURU'],
            ['MUSNIATI, S. Pd', '197406042007012019', 'III.d', 'GURU'],
            ['SRI MIRAWATI, S. Pd. I', '198008192007102003', 'III.d', 'GURU'],
            ['NURLAILI, S.HI', '198003082007102003', 'III.d', 'GURU'],
            ['ASNELI WARDINI, SHI, S. Pd. I', '197912082007102006', 'III.d', 'GURU'],
            ['ZALMI, S. Pd', '196711122005011005', 'III.d', 'GURU'],
            ['GUSNITA, S. Ag', '197108242007102001', 'III.d', 'GURU'],
            ['NURIDA, S. Pd', '197602102007102003', 'III.d', 'GURU'],
            ['RAHMI ARFIYENTI, S. Pd', '197104292007102002', 'III.d', 'GURU'],
            ['NUDDI SYARIF, S. Si', '197602052007011016', 'III.d', 'GURU'],
            ['HAFNITA SUKMAWATI, S. Pd', '197212162007012009', 'III.d', 'GURU'],
            ['DAHLENA, M.Pd', '197612132009012004', 'III.d', 'GURU'],
            ['MUHAMMAD ISNAINI,S.Pd.I', '197608022005011006', 'III.d', 'GURU'],
            ['SRI YANTI, S.Pd', '197801192007102003', 'III.c', 'GURU'],
            ['RAMA YULISDA, S. Ag', '197605012014112006', 'III.b', 'GURU'],
            ['SUSMANTI, S.Pd', '198308062014112002', 'III.b', 'GURU'],
            ['RAHMI YULIA, S.Pd', '198507132019032014', 'III.b', 'GURU'],
            ['SRI NOVIA ALIM, S.Pd.I', '198503022019032012', 'III.b', 'GURU'],
            ['MUTIARA ANGELINA, S.Pd', '199707312019032002', 'III.b', 'GURU'],
            ['KUNTUM ALMA LANY, S.Pd', '199108202019032020', 'III.b', 'GURU'],
            ['AMETADEVI TRESIA, S.Pd', '198501022019032015', 'III.b', 'GURU'],
            ['RISA DWITA PUTRI, S.Pd', '198907012019032012', 'III.b', 'GURU'],
            ['INDRI RAHMAWATI, S.Pd', '199008172019032029', 'III.b', 'GURU'],
            ['ELIN NOFIA JUMESA, S.Pd', '199511102019032017', 'III.b', 'GURU'],
            ['BENNY WAHYUDI, S.KOM', '198405262019031005', 'III.b', 'GURU'],
            ['ROZA IDA YANI, S.Pd', '198901132019032012', 'III.b', 'GURU'],
            ['IMALDA IFRIANI, S.Pd.I', '198908272019032019', 'III.b', 'GURU'],
            ['ALMASRI PUTRA, S.Pd', '199108232019031015', 'III.b', 'GURU'],
            ['TRI SUCI PRIMA AMELIA PUTRI, S.Pd', '198705052019032013', 'III.b', 'GURU'],
            ['NITTO WILIAM, S.KOM', '199007272019031011', 'III.b', 'GURU'],
            ['ZAINAL, S.Pd', '197611182023211002', 'IX', 'GURU'],
            ['RINI AMELIA, S.KOM', '198505142023212032', 'IX', 'GURU'],
            ['YUWENDI ZARLI, S.Pd', '197809142023212015', 'IX', 'GURU'],
            ['ARJUN RIANI ASTUTI, S. Pd. I', '198206232023212024', 'IX', 'GURU'],
            ['AFRILINITA, S.Pd', '199304192023212039', 'IX', 'GURU'],
            ['SILVIA, S.Pd', '197805232023212012', 'IX', 'GURU'],
            ['IQBAL ARIF, S.Pd', '198802232023211015', 'IX', 'GURU'],
            ['DARWIMAH, S. Pd', '197101062007102002', 'III.d', 'PEGAWAI'],
            ['DESMALIDAR, S.A.P', '196804172014112002', 'III.a', 'PEGAWAI'],
            ['MONDRA SEPNITON, SS', '198109062025211009', 'IX', 'GURU'],
            ['DONA GUSTIA, S. Pd. I', '198508212025212012', 'IX', 'GURU'],
            ['ISHAQ HALIM, S. Ag', '197001012025211011', 'IX', 'GURU'],
            ['IHSAN, M.Pd', '197408122025211010', 'IX', 'GURU'],
            ['DILLA OKTAVIANA, S. Pd', '198710212025212003', 'IX', 'GURU'],
            ['SYUKRIADI, SS', '198410072025211004', 'IX', 'GURU'],
            ['SYAFRIZAL, S. Pd. I', '198401202025211004', 'IX', 'GURU'],
            ['RANI WAHYUNI, S. Pd', '198102192025212005', 'IX', 'GURU'],
            ['YUTNITA, S.Pd', '198309022025212001', 'IX', 'GURU'],
            ['DORI EKA PUTRA, S.Pd', '198712172025211002', 'IX', 'GURU'],
            ['MUHAMMAD IKHSAN, S.Pd', '199009292025211020', 'IX', 'GURU'],
            ['LIA APRIANI, S. Pd. I', '199304132025212013', 'IX', 'GURU'],
            ['RICE MAI YUNI, S.Pd', '199505302025212018', 'IX', 'GURU'],
            ['GUSNELI, S,Pd', '197202102025212005', 'IX', 'GURU'],
        ];

      DB::beginTransaction();

        try {

            foreach ($rows as $row) {
                $userId = DB::table('users')->insertGetId([
                    'name' => $row[0],
                    'email' => 'guru' . uniqid() . '@gmail.com',
                    'password' => Hash::make($row[1]),
                    'role' => 'guru',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                DB::table('guru')->insert([
                    'id_user'       => $userId,
                    'nama_guru'     => $row[0],
                    'nip'           => $row[1],
                    'golongan'      => $row[2],
                    'jabatan'       => $row[3],
                    'jenis_kelamin' => 'L',
                    'alamat'        => '-',
                    'no_hp'         => '-',
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ]);
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
};

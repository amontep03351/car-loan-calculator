<?php 
namespace App\Http\Livewire;

use Livewire\Component;

class CarLoanCalculator extends Component
{
    public $loanAmount = 0;
    public $interestRate = 0;
    public $installments = 12;
    public $paymentSchedule = [];

    public function calculate()
    {
        // เริ่มต้นอาร์เรย์สำหรับจัดเก็บตารางการผ่อนชำระ
        $this->paymentSchedule = [];
        
        // แปลงค่าจำนวนเงินกู้และอัตราดอกเบี้ยเป็นจำนวนจริงเพื่อการคำนวณที่แม่นยำ
        $loanAmount = floatval($this->loanAmount);
        $interestRate = floatval($this->interestRate);
        $installments = intval($this->installments);

        // ตรวจสอบว่าค่าที่ป้อนมีความถูกต้องและเหมาะสมในการคำนวณ
        if ($loanAmount > 0 && $interestRate > 0 && $installments > 0) {
            // แปลงอัตราดอกเบี้ยรายปีเป็นอัตราดอกเบี้ยรายเดือน
            $annualInterestRate = $interestRate / 100;
            $monthlyInterestRate = $annualInterestRate / 12;
            $numberOfPayments = $installments;

            // คำนวณการผ่อนชำระเงินต้นที่ต้องจ่ายในแต่ละเดือน
            $monthlyPayment = $loanAmount / $numberOfPayments;
            $remainingLoanAmount = $loanAmount;

            // วนลูปคำนวณรายละเอียดการชำระเงินสำหรับแต่ละงวด
            for ($i = 1; $i <= $numberOfPayments; $i++) {
                // คำนวณการชำระดอกเบี้ยสำหรับงวดปัจจุบัน
                $interestPayment = $remainingLoanAmount * $monthlyInterestRate;

                // การชำระเงินต้นที่ต้องจ่ายในแต่ละเดือน
                $principalPayment = $monthlyPayment;

                // คำนวณการชำระเงินรวมสำหรับงวดปัจจุบัน
                $totalPayment = $principalPayment + $interestPayment;

                // เพิ่มรายละเอียดการชำระเงินลงในตาราง
                $this->paymentSchedule[] = [
                    'installment' => $i,
                    'principal' => $principalPayment, // ค่าที่เป็น float
                    'interest' => $interestPayment, // ค่าที่เป็น float
                    'total' => $totalPayment // ค่าที่เป็น float
                ];
                
                // อัพเดตยอดเงินกู้ที่เหลือหลังจากการชำระเงินต้น
                $remainingLoanAmount -= $principalPayment;
            }
        }
    }
    public function clear()
    {
        // Reset form fields and payment schedule
        $this->loanAmount = 0;
        $this->interestRate = 0;
        $this->installments = 12;
        $this->paymentSchedule = [];
    }
    public function render()
    {
        return view('livewire.car-loan-calculator');
    }
}

<?php

namespace App\Livewire\Modal;

use App\Models\Bill;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Str;
use Nette\Utils\Random;

class BillModal extends Component
{
    public $deleting = false;
    public $editing = false;
    public $showing = false;
    public $bill_id;
    public $customer_id = '';
    public $period;
    public $meter_start;
    public $meter_end;
    public $usage;
    public $status;
    public $due_date;
    public $customers = [];
    public $customerInfo;
    public $total_meter;
    public $total_bill;
    public $invoice;
    public $customer_name;
    public $bill;

    /**
     * Mount the component with the given customers.
     *
     * @param  mixed $customers
     * @return void
     */
    public function mount($customers)
    {
        $this->customers = $customers;
    }

    /**
     * Update the component when a property changes.
     *
     * @param  mixed $property
     * @return void
     */
    public function updated($property, $value)
    {
        if ($property == 'customer_id') {
            // jika ada sebelumnya tidak ada data bill,  ambil initial meter dari customer
            $customer = Customer::findOrFail($this->customer_id);
            $this->customerInfo = $customer;

            $billLast = $this->customerInfo->bills()->latest()->first();
            $this->meter_start = $billLast ? $billLast->meter_end : $this->customerInfo->initial_meter;
            $this->period = $billLast ? null : now()->format('Y-m');
            $this->invoice = "INV-" . Random::generate(8, '0-9A-Z');
            $this->due_date = $billLast
                ? $billLast->due_date
                : Carbon::parse($this->period)->day(20)->addMonth()->format('Y-m-d');

            $this->resetErrorBag(['customer_id', 'meter_start', 'invoice',]);

            if (!$billLast) $this->resetErrorBag('period');
        }

        if ($property == 'period') {
            $this->resetErrorBag('period');

            // jika sudah ada periode yg buat sebelumnya, tidak boleh dipakai lagi
            $checkPeriod = Bill::query()
                ->where('customer_id', $this->customer_id)
                ->where('period', $this->period)
                ->when($this->bill_id, function ($query) {
                    return $query->where('id', '!=', $this->bill_id);
                })->exists();

            if ($checkPeriod) {
                $periodFormatted = formatPeriod($this->period);
                $this->addError('period', "Periode {$periodFormatted} sudah ada tagihan sebelumnya.");
                $this->due_date = $this->editing ? $this->due_date : null;
                $this->period = null;
                $this->total_bill = null;
                return;
            }

            // automatis set due date 28 hari setelah periode
            $this->due_date = Carbon::parse($this->period)->day(20)->addMonth()->format('Y-m-d');
        }

        if (!empty($this->usage) && !empty($this->period)) {
            $this->meter_end = $this->meter_start + $this->usage;
            $this->total_meter = $this->meter_end - $this->meter_start;
            $rate = $this->customerInfo->tarif->price_per_kwh ?? 0;
            $this->total_bill = $this->total_meter * $rate;
            $this->resetErrorBag('meter_end');
        }
    }

    /**
     * Render the view for the bill modal.
     *
     * @return void
     */
    public function render()
    {
        return view('livewire.modal.bill-modal');
    }

    /**
     * Create a new bill.
     *
     * @return void
     */
    #[On('bill:create')]
    public function create()
    {
        $this->onreset(); // Reset all fields and error bags
        $this->dispatch('modal:show');
    }

    /**
     * Store the bill data.
     *
     * @return void
     */
    public function store()
    {
        $this->validate();

        // Calculate meter end with usage + meter start
        $this->meter_end = $this->meter_start + $this->usage;

        Bill::create([
            'customer_id' => $this->customer_id,
            'period' => $this->period,
            'meter_start' => $this->meter_start,
            'meter_end' => $this->meter_end,
            'due_date' => $this->due_date
                ? Carbon::parse($this->due_date)
                : Carbon::parse($this->period)->startOfMonth()->addDays(28),
            'status' => 'unpaid',
            'invoice' => $this->invoice,
        ]);

        $this->close();
        $this->dispatch('bill:success');
        $this->dispatch('toast', icon: 'success', message: 'Tagihan berhasil dibuat.');
    }

    /**
     * Edit an existing bill.
     *
     * @param  mixed $id
     * @return void
     */
    #[On('bill:edit')]
    public function edit($id)
    {
        $bill = Bill::findOrFail(decrypt($id));

        // Check if the bill is already paid
        if ($bill->status == 'paid') {
            $this->dispatch('toast', icon: 'error', message: 'Tagihan sudah dibayar, tidak bisa diubah.');
            return;
        }

        $this->editing = true;
        $this->bill = $bill;
        $this->bill_id = $bill->id;
        $this->customer_name = "{$bill->customer->user->name} ({$bill->customer->meter_number})";
        $this->invoice = $bill->invoice;
        $this->meter_start = $bill->meter_start;
        $this->usage = $bill->usage;
        $this->period = Carbon::parse($bill->period)->format('Y-m');
        $this->due_date = Carbon::parse($bill->due_date)->format('Y-m-d');
        $this->customer_id = $bill->customer_id;
        $this->customerInfo = $bill->customer;

        $this->reset(['deleting', 'showing']); // Reset deleting state to false
        $this->dispatch('modal:show');
    }

    /**
     * Update the bill data.
     *
     * @return void
     */
    public function update()
    {
        $this->validate();

        $this->meter_end = $this->meter_start + $this->usage;

        $bill = Bill::findOrFail($this->bill_id);
        $bill->update([
            'period' => $this->period,
            'meter_end' => $this->meter_end,
            'due_date' => $this->due_date
                ? Carbon::parse($this->due_date)
                : Carbon::parse($this->period)->startOfMonth()->addDays(28),
        ]);

        $this->close();
        $this->dispatch('bill:success'); // <-- send event to Bill component
        $this->dispatch('toast', icon: 'success', message: 'Data tagihan berhasil diperbarui.');
    }

    /**
     * Delete a bill.
     *
     * @param  mixed $id
     * @return void
     */
    #[On('bill:delete')]
    public function delete($id)
    {
        $id = decrypt($id);
        $bill = Bill::findOrFail($id);

        if ($bill->status == 'paid') {
            $this->dispatch('toast', icon: 'error', message: 'Tagihan sudah dibayar, tidak bisa dihapus.');
            return;
        }

        $this->deleting = true;
        $this->bill_id = $bill->id;
        $this->customerInfo = $bill->customer;
        $this->period = formatPeriod($bill->period);
        $this->usage = $bill->usage;

        $this->reset(['editing', 'showing']); // Reset editing state to false
        $this->dispatch('modal:show');
    }

    /**
     * Delete the bill and associated customer user.
     *
     * @return void
     */
    public function deleted()
    {
        $bill = Bill::findOrFail($this->bill_id);
        $bill->delete(); // Delete the bill

        $this->close();
        $this->dispatch('bill:success'); // <-- send event to Bill component
        $this->dispatch('toast', icon: 'success', message: 'Data tagihan berhasil dihapus.');
    }

    /**
     * Show the bill details in a modal.
     *
     * @param  mixed $id
     * @return void
     */
    #[On('bill:show')]
    public function detail($id)
    {
        $bill = Bill::with([
            'customer',
            'customer.tarif',
            'customer.user',
            'payment'
        ])->findOrFail(decrypt($id));

        $this->showing = true;
        $this->bill = $bill;

        $this->dispatch('modal:show');
    }

    /**
     * Close the bill modal.
     *
     * @return void
     */
    public function close()
    {
        $this->dispatch('modal:hide');
    }

    /**
     * Close the modal and reset all fields.
     *
     * @return void
     */
    #[On('modal:onreset')]
    public function onreset()
    {
        $this->reset([
            'deleting',
            'editing',
            'bill_id',
            'customer_id',
            'meter_start',
            'meter_end',
            'status',
            'due_date',
            'period',
            'customerInfo',
            'total_meter',
            'total_bill',
            'invoice',
            'usage',
            'customer_name',
            'bill',
            'showing',
        ]);

        $this->resetErrorBag();
    }

    /**
     * rules
     *
     * @return void
     */
    protected function rules()
    {
        return [
            'customer_id' => 'required|exists:customers,id',
            'period' => 'required|date_format:Y-m',
            'meter_start' => 'required|numeric|min:0',
            'usage' => 'required|numeric|min:10',
            'due_date' => 'nullable|date|after_or_equal:today',
            'invoice' => [
                'required',
                'string',
                'max:255',
                Rule::unique('bills')->where(function ($query) {
                    return $query->where('customer_id', $this->customer_id)
                        ->where('period', $this->period);
                })->ignore($this->bill_id, 'id'),
            ],
        ];
    }

    /**
     * messages
     *
     * @return void
     */
    protected function messages()
    {
        return [
            'customer_id.required'         => 'Pelanggan harus dipilih.',
            'customer_id.exists'           => 'Pelanggan tidak ditemukan.',
            'period.required'              => 'Periode wajib diisi.',
            'period.date_format'           => 'Format periode harus YYYY-MM.',
            'meter_start.required'         => 'Meteran bulan lalu wajib diisi.',
            'meter_start.numeric'          => 'Meteran bulan lalu harus berupa angka.',
            'meter_start.min'              => 'Meteran bulan lalu minimal :min.',
            'usage.required'               => 'Pemakaian listrik wajib diisi.',
            'usage.numeric'                => 'Pemakaian listrik harus berupa angka.',
            'usage.min'                    => 'Pemakaian listrik minimal :min kWh.',
            'due_date.date'                => 'Tanggal jatuh tempo harus berupa tanggal yang valid.',
            'due_date.after_or_equal'      => 'Tanggal jatuh tempo tidak boleh kurang dari hari ini.',
            'invoice.required'             => 'Nomor invoice wajib diisi.',
            'invoice.string'               => 'Nomor invoice harus berupa string.',
            'invoice.max'                  => 'Nomor invoice maksimal :max karakter.',
            'invoice.unique'               => 'Nomor invoice sudah digunakan untuk tagihan pada periode yang sama.',
        ];
    }
}

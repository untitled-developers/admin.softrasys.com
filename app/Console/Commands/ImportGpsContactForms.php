<?php

namespace App\Console\Commands;

use App\Models\GpsContactForm;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ImportGpsContactForms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gps:import-contact-forms
                            {path? : Path to the CSV file (defaults to data/contact_data.csv)}
                            {--dry-run : Parse and report without writing to the database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import contact_data.csv into the gps_contact_forms table, preserving the original submission dates';

    public function handle(): int
    {
        $path = $this->argument('path') ?? base_path('data/contact_data.csv');
        $dryRun = (bool) $this->option('dry-run');

        if (! is_file($path) || ! is_readable($path)) {
            $this->error("CSV file not found or not readable: {$path}");
            return self::FAILURE;
        }

        $handle = fopen($path, 'r');
        if ($handle === false) {
            $this->error("Unable to open CSV file: {$path}");
            return self::FAILURE;
        }

        $this->info("Importing from: {$path}" . ($dryRun ? ' (dry run)' : ''));

        $header = fgetcsv($handle); // discard header row
        if ($header === false) {
            $this->error('CSV file is empty.');
            fclose($handle);
            return self::FAILURE;
        }

        $imported = 0;
        $skippedBlank = 0;
        $skippedDuplicate = 0;
        $badDate = 0;
        $line = 1; // header consumed

        while (($row = fgetcsv($handle)) !== false) {
            $line++;

            // Column layout:
            // 0 Name, 1 Email, 2 Phone, 3 Country, 4 Vehicles,
            // 5 Industry, 6 Subject, 7 Message, 8 Date, 9 Source
            $name    = $this->clean($row[0] ?? null);
            $email   = $this->clean($row[1] ?? null);
            $phone   = $this->clean($row[2] ?? null);
            $country = $this->clean($row[3] ?? null);
            $vehicles = $this->clean($row[4] ?? null);
            $industry = $this->clean($row[5] ?? null);
            $subject  = $this->clean($row[6] ?? null);
            $message  = $this->clean($row[7] ?? null);
            $rawDate  = $this->clean($row[8] ?? null);
            $source   = $this->clean($row[9] ?? null);

            // Skip completely blank rows (no name and no email).
            if ($name === null && $email === null) {
                $skippedBlank++;
                continue;
            }

            // Parse the original submission date.
            $date = $this->parseDate($rawDate);
            if ($date === null) {
                $badDate++;
                $date = Carbon::now();
                $this->warn("Line {$line}: unparseable date '" . ($rawDate ?? '') . "', using current time.");
            }

            // The CSV carries a Subject the table has no column for; fold it into the message.
            $fullMessage = $this->combineMessage($subject, $message);

            // Idempotency guard: same email + same created_at means already imported.
            $exists = GpsContactForm::query()
                ->where('email', $email)
                ->where('created_at', $date->format('Y-m-d H:i:s'))
                ->exists();

            if ($exists) {
                $skippedDuplicate++;
                continue;
            }

            if (! $dryRun) {
                $model = new GpsContactForm();
                $model->name = $name ?? '';
                $model->email = $email ?? '';
                $model->phone_number = $phone ?? '';
                $model->country = $country;
                $model->number_of_vehicles = $vehicles;
                $model->industry = $industry;
                $model->message = $fullMessage;
                $model->source = $source;

                // Preserve the original dates instead of letting Eloquent stamp "now".
                $model->timestamps = false;
                $model->created_at = $date;
                $model->updated_at = $date;
                $model->save();
            }

            $imported++;
        }

        fclose($handle);

        $this->newLine();
        $this->info(($dryRun ? 'Would import' : 'Imported') . ": {$imported}");
        $this->line("Skipped (blank rows): {$skippedBlank}");
        $this->line("Skipped (already imported): {$skippedDuplicate}");
        if ($badDate > 0) {
            $this->line("Rows with unparseable dates (fell back to now): {$badDate}");
        }

        return self::SUCCESS;
    }

    /**
     * Trim a CSV cell and normalise empty / placeholder values to null.
     */
    private function clean(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim($value);

        if ($value === '' || strtolower($value) === 'null' || $value === '-1') {
            return null;
        }

        return $value;
    }

    /**
     * Fold the CSV Subject into the Message field (no dedicated subject column).
     */
    private function combineMessage(?string $subject, ?string $message): ?string
    {
        if ($subject !== null && $message !== null) {
            return "Subject: {$subject}\n\n{$message}";
        }

        if ($subject !== null) {
            return "Subject: {$subject}";
        }

        return $message;
    }

    /**
     * Parse the CSV date, returning null when it cannot be understood.
     */
    private function parseDate(?string $rawDate): ?Carbon
    {
        if ($rawDate === null) {
            return null;
        }

        $parsed = Carbon::createFromFormat('Y-m-d H:i:s', $rawDate);
        if ($parsed !== false) {
            return $parsed;
        }

        try {
            return Carbon::parse($rawDate);
        } catch (\Throwable $e) {
            return null;
        }
    }
}

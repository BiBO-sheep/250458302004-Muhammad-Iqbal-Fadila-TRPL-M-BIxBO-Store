<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Review;
use App\Models\ReviewsTable;

class ReviewCreatedNotification extends Notification
{
    use Queueable;

    protected $review;

    public function __construct(ReviewsTable $review)
    {
        $this->review = $review;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Review on Your Product')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('You have received a new review on your product: ' . $this->review->product->name)
            ->line('Rating: ' . str_repeat('⭐', $this->review->rating))
            ->line('Comment: ' . $this->review->comment)
            ->action('View Review', route('seller.reviews.index'))
            ->line('Thank you for selling on QuickCart!');
    }

    public function toArray($notifiable)
    {
        return [
            'review_id' => $this->review->id,
            'product_id' => $this->review->product_id,
            'product_name' => $this->review->product->name,
            'rating' => $this->review->rating,
            'customer_name' => $this->review->user->name
        ];
    }
}

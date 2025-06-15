<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $project_id
 * @property int $marketing_category_id
 * @property int|null $monthly_management_fee
 * @property int|null $advertising_cost
 * @property string|null $advertising_payer
 * @property string|null $post_frequency
 * @property string|null $notes
 * @property string|null $order_date
 * @property string $status
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\MarketingCategory $marketingCategory
 * @property-read \App\Models\Project $project
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketing newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketing newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketing query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketing whereAdvertisingCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketing whereAdvertisingPayer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketing whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketing whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketing whereMarketingCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketing whereMonthlyManagementFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketing whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketing whereOrderDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketing wherePostFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketing whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketing whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Marketing whereUpdatedAt($value)
 */
	final class Marketing extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Marketing> $marketing
 * @property-read int|null $marketing_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MarketingCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MarketingCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MarketingCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MarketingCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MarketingCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MarketingCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MarketingCategory whereUpdatedAt($value)
 */
	final class MarketingCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $company_name
 * @property string $website_url
 * @property string|null $hosting_info
 * @property \Carbon\CarbonImmutable|null $last_update_date
 * @property \Carbon\CarbonImmutable $next_update_date
 * @property string|null $update_frequency
 * @property int $contract_status
 * @property int|null $contract_amount
 * @property string $currency
 * @property string|null $notes
 * @property \Illuminate\Database\Eloquent\Collection<int, \App\Models\Upsell> $upsells
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Marketing> $marketing
 * @property-read int|null $marketing_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UpsellCategory> $upsellCategories
 * @property-read int|null $upsell_categories_count
 * @property-read int|null $upsells_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereContractAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereContractStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereHostingInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereLastUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereNextUpdateDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereUpdateFrequency($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereUpsells($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project whereWebsiteUrl($value)
 */
	final class Project extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $project_id
 * @property int $upsell_category_id
 * @property string|null $description
 * @property int $price
 * @property string $status
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \App\Models\Project $project
 * @property-read \App\Models\UpsellCategory $upsellCategory
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Upsell newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Upsell newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Upsell query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Upsell whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Upsell whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Upsell whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Upsell wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Upsell whereProjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Upsell whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Upsell whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Upsell whereUpsellCategoryId($value)
 */
	final class Upsell extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Upsell> $upsells
 * @property-read int|null $upsells_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UpsellCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UpsellCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UpsellCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UpsellCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UpsellCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UpsellCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UpsellCategory whereUpdatedAt($value)
 */
	final class UpsellCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Carbon\CarbonImmutable|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	final class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}


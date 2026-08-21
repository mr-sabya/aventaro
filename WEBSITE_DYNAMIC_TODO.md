# Aventaro Website Dynamic Development To-Do

## Audit summary

The project already contains backend models and admin management for several areas, including hero slides, destinations, tours, partners, and homepage section settings. However, most public-facing templates still display hardcoded demo content. The main task is connecting the existing backend data to the frontend, then implementing the missing workflows.

## Priority 1 — Connect existing CMS data

- [x] Load active `HeroSlide` records in the homepage slider.
- [x] Replace hardcoded hero titles, descriptions, images, and buttons.
- [x] Connect `TrendingDestinationSection` settings to the homepage.
- [x] Load active/trending destinations dynamically.
- [x] Connect the homepage About block to `AboutSection`.
- [x] Load partner logos dynamically from `Partner`.
- [x] Connect the brand heading to `BrandSection`.
- [x] Connect the Featured Places heading to `FeaturedTourSection`.
- [x] Load active featured tours using `is_featured`.
- [x] Connect the Discover section to `DiscoverSection`.
- [x] Load hot-deal tours using `is_hot_deal`.
- [x] Replace homepage `.html` links with named Laravel routes.

## Priority 2 — Dynamic listing and detail pages

### Tours

- [x] Make `/tour-packages` query the `tours` table.
- [x] Add pagination.
- [x] Add a tour detail route such as `/tour-packages/{tour:slug}`.
- [x] Convert `tour-details.html` into a Blade page.
- [x] Display tour description, pricing, duration, city, address, and images.
- [x] Display amenities and day-by-day tour plans.
- [x] Display map and tour features.
- [x] Display approved reviews.
- [x] Add working review submission and admin moderation.
- [x] Add related tours.
- [x] Add search/filtering by destination, date, price, and duration.

### Destinations

- [x] Make `/destinations` query active destinations.
- [x] Add pagination.
- [x] Add a destination detail route using its slug.
- [x] Convert `destination-details.html` into Blade.
- [x] Display city, country, currency, languages, and visa requirements.
- [x] Display description, features, map, and related FAQs.
- [x] Display tours available for the destination.
- [x] Replace destination demo cards throughout the About and homepage pages.

## Priority 3 — Booking system

The website presents itself as a booking website, but no booking model or workflow currently exists.

- [x] Create the bookings database table and model.
- [x] Add traveller count, travel date, and contact fields.
- [x] Calculate price and booking totals securely on the server.
- [x] Add booking availability/capacity management.
- [x] Add booking confirmation numbers and statuses.
- [x] Create customer confirmation page and email.
- [x] Add an admin booking list and booking details.
- [x] Add cancel, confirm, complete, and refund statuses.
- [x] Add payment method/status tracking with pay-later and bank-transfer methods. An external online gateway can be connected when a provider is selected and credentials are configured.
- [x] Add coupon and discount management.

## Priority 4 — Remaining homepage sections

These homepage sections are currently hardcoded:

- [x] Make the “Why choose us” feature ticker dynamic.
- [x] Make the tour guiding team dynamic.
- [x] Make the “Inspiration for Future Travel” categories dynamic.
- [x] Make the discount promotional banner dynamic.
- [x] Make testimonials dynamic.
- [x] Make the latest news/articles block dynamic.
- [x] Make the app download promotion dynamic.
- [x] Add models, migrations, admin management, active status, image uploads, and sort order where appropriate.

## Priority 5 — Blog/news system

- [x] Create posts, categories, and tags.
- [x] Add authors, featured images, excerpts, full content, and publish dates.
- [x] Add draft/published status and scheduled visibility.
- [x] Make the news listing dynamic and paginated.
- [x] Add a slug-based news detail route and Blade template.
- [x] Implement popular/latest posts and view counts.
- [x] Implement category and tag filtering.
- [x] Make news search work.
- [x] Keep comments disabled because they are optional and no moderation workflow is currently required.
- [x] Add dedicated article, category, and tag management to the admin panel.

## Priority 6 — Team and testimonials

- [x] Create and extend the team-member model with admin CRUD, bios, contact details, experience, social links, ordering, and active status.
- [x] Convert team listing/detail templates from static `.html` designs to dynamic Blade pages.
- [x] Add paginated team listing and slug-based detail routes.
- [x] Replace hardcoded homepage and About-page team members.
- [x] Create a testimonial model and admin CRUD.
- [x] Load only active, approved testimonials dynamically.

## Priority 7 — Contact, newsletter, and search

- [x] Fix the contact URL typo with `/contact-us` and retain a permanent redirect from `/conatct-us`.
- [x] Replace the external template contact action with a Laravel endpoint.
- [x] Validate and save contact messages with request metadata.
- [x] Add honeypot spam protection and rate limiting.
- [x] Add an admin inbox with new/read/replied states, filtering, email reply links, and deletion.
- [x] Send contact notification emails to the configured contact address.
- [x] Make the off-canvas appointment form functional.
- [x] Create newsletter subscriber storage with resubscription support.
- [x] Connect the footer newsletter form.
- [x] Add token-based unsubscribe support.
- [x] Implement the global search overlay and results page.
- [x] Search active tours, active destinations, and published articles.

## Priority 8 — Header, footer, and general settings

  - [x] Create general website settings.
  - [x] Manage site name, logos, and favicon.
  - [x] Manage phone number, email, and address.
  - [x] Manage social-media URLs.
  - [x] Manage header and footer buttons.
  - [x] Manage footer link groups and gallery.
  - [x] Manage copyright text.
  - [x] Remove remaining “Travil” demo branding.
  - [x] Make currency selection functional.
  - [x] Make language selection functional, or remove it until supported.
  - [x] Make navigation active states route-aware.
  - [x] Replace broken admin template links such as Widgets, Profile, and Settings.

## Priority 9 — About and other content pages

- [ ] Create editable About-page sections.
- [ ] Make promise/benefit blocks dynamic.
- [ ] Make counters and statistics dynamic.
- [ ] Make the destination carousel dynamic.
- [ ] Make team, app promotion, and latest-news blocks dynamic.
- [ ] Create reusable page and breadcrumb settings.
- [ ] Convert the FAQ template into a working Blade route.
- [ ] Create Privacy Policy and Terms pages.
- [ ] Implement the custom 404 page through Laravel.

## Priority 10 — Shop templates

Shop, cart, checkout, and product templates exist, but they are un-routed static HTML files without supporting models.

Choose one direction:

- [ ] Remove shop templates and assets if e-commerce is outside the project scope.

Or:

- [ ] Build products, categories, inventory, cart, checkout, orders, coupons, and payments.
- [ ] Convert all shop `.html` templates to Blade.
- [ ] Add customer order history and admin order management.

## Priority 11 — SEO, reliability, and security

- [ ] Replace the global demo page title and description.
- [ ] Add per-page titles and meta descriptions.
- [ ] Add canonical URLs and social-sharing metadata.
- [ ] Add structured data for tours, destinations, articles, and reviews.
- [ ] Generate the XML sitemap dynamically.
- [ ] Configure production `robots.txt`.
- [ ] Add image alt-text fields.
- [ ] Add image resizing and WebP optimization.
- [ ] Add unique validation and safe upload validation.
- [ ] Sanitize rich-text content.
- [ ] Add admin authorization beyond a single `is_admin` flag if multiple staff roles are needed.
- [ ] Add password reset and admin profile management.
- [ ] Add database seed data for all major sections.
- [ ] Add feature tests for public pages and admin CRUD.
- [ ] Add tests for booking, contact, and review submission.
- [ ] Add empty-state handling when database records do not exist.

## Recommended implementation order

1. Connect the existing homepage models to the frontend.
2. Build dynamic tour and destination listings and detail pages.
3. Build the booking workflow.
4. Implement contact messages, newsletter subscriptions, and search.
5. Build the blog and remaining homepage CMS blocks.
6. Add general website settings, SEO, tests, and production hardening.

## Laravel Multi-Tenant CRM Boilerplate

Hi everyone, my name is Huseyin. I would like to share with you this CRM boilerplate that I have developed. I just wanted to create this boilerplate in order to speed up a crm development process by having the must have features out of the box. I have been working on this for a while and I think it is time to share it with the community.

I have kept this project as much simple and clean as possible. I have worked for a few projects that required almost the same features at first place and I thought that developers like me might want to save some time and get rid of that boring setup process.

## What have I used in this project?

* Laravel 13.8
* Livewire 4.3
* PHP 8.3
* Tabler Admin Template (based on bootstrap 5)
* Laravel Spatie Permissions (for role/permission management)
* Laravel Spatie Activitylog (for logging user actions)

- Forms inside modals are automatically reset when the modal is closed.
- Users can be assigned in global level and company level.
- Users can belong to multiple companies.
- Users can have multiple roles and different titles in various companies.
- I have received AI assistance in complex parts like multi-tenant structure to speed up and reduce possible errors. But I have built its base structure and logic entirely by myself by utilizing laravel spatie permissions package.

## Folder Structure

- resources/views/admin: All admin pages
- resources/views/auth: All authentication related pages
- resources/views/pages: All the user interface pages
- resources/views/components/livewire: All of the livewire form/modal components
- resources/css/tabler: Tabler template css files

* Note: *This project uses actions and dtos in order to keep the code clean and organized. It is not a requirement to use them when you edit it.*
- app/Actions: Database transactions such as create/update
- app/DTOs: Data transfer objects to deliver variables between layers strictly

### Conclusion

I am open to any suggestions and feedback. Please feel free to contribute to this project.

If you have any questions, you can contact me via [huseyinemeci@gmail.com] or my personal website [https://huseyinemeci.com].

Thank you for reading this. I hope this project helps you in your future projects.
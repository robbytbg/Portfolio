# Customer Caring Platform

**INTRODUCTION**

The **Customer Caring Integrated Platform** is designed to facilitate the management of customer data and their interactions within an organization. This platform, built using **PHP Laravel**, streamlines the operational workflow of customer service teams, enabling them to view, manage, and update customer information in a secure and structured manner. Access to the platform is role-based, ensuring that only authorized personnel can modify or interact with sensitive data. The primary purpose of the system is to provide a centralized dashboard for customer and business management, improving the efficiency of customer service operations and decision-making.

In this system, there are four key roles: **super admin**, **admin**, **editor**, and **viewer**, each with defined permissions. The super admin has the highest level of control, such as managing user roles and removing users from the system. Other roles (admin, editor, and viewer) have progressively fewer permissions, ensuring data integrity and access control.

Access to the platform is secured through an OTP-based authentication system, integrated with **Telegram**, ensuring that only verified users can log in. Users who do not meet the minimum access level (viewer) are redirected to an unauthorized access page, further enhancing the platform's security.

**OBJECTIVES**

The primary objective of the **Customer Caring Integrated Platform** is to help customer service representatives manage customer data effectively and present it in an organized manner via a comprehensive dashboard. Specific objectives include:

1. **Role-based access control**: Provide a secure and structured way to manage user roles and access.
1. **Customer data management**: Enable admins and editors to manage customer data, including modifying credentials and updating caring statuses.
1. **Interactive dashboard**: Present customer data and business metrics using visually appealing charts and graphs, allowing users to filter and drill down into the data for deeper insights.
1. **Streamlined workflows**: Allow easy importing of customer data via Excel files and manual creation of entities to keep the system up to date.
1. **Business insights**: Provide a business report section that helps analyze day- to-day growth, payment statuses, and other key performance metrics.

**SYSTEM OVERVIEW**

The **Customer Caring Integrated Platform** consists of several core modules, each designed to handle specific aspects of customer data management:

1. **Super Admin Page**: This page is exclusively for users with the super admin role. It allows them to assign or remove user roles and delete users from the database. The super admin role is only accessible through a short-term URL generated for enhanced security.
1. **Admin Page**: Admins can manage the UserSheet, where they can edit sheet codes, update customer credentials, upload files (in Excel format) as new sheets, and manually create entities.
1. **Dashboard**: The dashboard is divided into two segments:.
1) **Caring Dashboard**: Presents various visualizations such as the SheetCode distribution (pie chart), total customer count per caring person (bar chart), caring intensity (line chart), and customer status (bar chart). These visualizations are filterable by year and month and allow drill-down for more detailed analysis.
1) **Business Report**: Displays key business metrics including a detailed matrix report, payment status (sunburst chart), and day-to-day TOTAG growth (clustered and line charts)
4. **SheetCodes Page**: Displays customer data and allows editors and above to update the caring status. The page also includes powerful filtering options and the ability to export the data in Excel format.

**FEATURES**

1. **Role-Based Access**: Only the super admin can assign and remove roles, ensuring strict access control. Super admin access is further secured by generating short-term URLs, while other users log in using OTP sent via Telegram.
1. **Data Management**: Admins and editors can manage customer data efficiently, including uploading new sheets or editing existing customer information.
1. **Visual Dashboards**: The dashboard provides interactive visualizations for both customer caring and business reports. Users can filter data, drill down into detailed reports, and analyze customer-related statistics over time.
1. **Secure and Filterable Data Access**: Editors can modify customer caring statuses, and all users can filter data by various parameters like sheet code and customer status, allowing them to retrieve exactly the data they need.

**TECHNOLOGIES AND DEPENDENCIES**

This project is built using the **PHP Laravel** framework version 11.0, requiring PHP 8.2 as the base language. The platform relies on several key dependencies to ensure smooth operation, security, and data management capabilities. These dependencies are managed through Laravel's composer.json file, which automatically loads necessary packages and libraries.

**Core Dependencies:**

1. **Laravel Framework**: The core of the platform, providing structure, routing, and database management.
1. **ext-gd**: Enables image processing for features like file uploads.
1. **Longman Telegram Bot**: Integrates with Telegram for OTP generation to authenticate users.
1. **Maatwebsite Excel**: Facilitates the import and export of customer data through Excel sheets.
1. **Spatie Laravel Permission**: Provides role-based access control, ensuring that only authorized users can modify critical parts of the system

**Development Dependencies:**

1. **Laravel Breeze**: Provides a simple and lightweight authentication system for managing user access.
1. **PHPUnit**: Provides a robust testing framework for ensuring the stability of the application.
1. **Spatie Laravel Ignition**: A debugging tool that enhances error reporting and troubleshooting during development.

**SYSTEM DESIGN**

1. **System Roles and Use Cases**

The **Customer Caring Integrated Platform** supports multiple user roles: **Super Admin**, **Admin**, **Editor**, and **Viewer**. Each role has specific access and functionality within the system, as depicted in the following use case diagram:

![](https://github.com/robbytbg/Customer-Caring-Platform/blob/4c599ec626e0c0874f7ad10240c7acb90db9d33c/related%20images/Aspose.Words.d5885a87-a8bc-42f3-a8cb-803caf7c8d57.004.jpeg)

- **Super Admin**: Manages user roles, assigns permissions, and handles account deletions.
- **Admin**: Has access to the admin page to manage the user sheet, edit sheet codes, and create or delete customer records.
- **Editor**: Can edit the customer sheet, including updating customer information and managing sheet codes.
- **Viewer**: Primarily has read-only access, viewing the dashboard and sheet data.
2. **User Authentication and Role-Based Access Control**

The **sequence diagram** below outlines the process of user authentication and role- based access control in the platform. This process ensures that users with the correct roles gain access to their designated pages, while others are redirected to a restricted page.

![](https://github.com/robbytbg/Customer-Caring-Platform/blob/4c599ec626e0c0874f7ad10240c7acb90db9d33c/related%20images/Aspose.Words.d5885a87-a8bc-42f3-a8cb-803caf7c8d57.005.jpeg)

1. **Access Login**: The user inputs their credentials on the login page.
1. **Validation**: The system validates user credentials with the database.
1. **OTP Verification**: Once validated, an OTP is sent to the user for two-factor authentication.
1. **Role Validation**: After OTP success, the user's role is verified to ensure proper access to different pages.
1. **Access Granted/Restricted**: Based on the role, the user is either granted access to the platform or redirected to the restricted access page.

**CHART & DIAGRAM**

1. **Caring Dashboard**

![](https://github.com/robbytbg/Customer-Caring-Platform/blob/4c599ec626e0c0874f7ad10240c7acb90db9d33c/related%20images/Aspose.Words.d5885a87-a8bc-42f3-a8cb-803caf7c8d57.006.jpeg)

**Sheet Code Distribution**

- Represents the composition of the customer base based on different categories or segments.

**Total Customer per Caring In-Charge**

- Compares the workload and responsibilities of different caring agents.

**Caring Intensity**

- Tracks the level of customer engagement or support provided by caring agents over time.

**Customers Status**

- Shows the current state or status of customers, indicating their engagement, satisfaction, or issues.
2. **Business Report**

![](https://github.com/robbytbg/Customer-Caring-Platform/blob/4c599ec626e0c0874f7ad10240c7acb90db9d33c/related%20images/Aspose.Words.d5885a87-a8bc-42f3-a8cb-803caf7c8d57.007.jpeg)

**Matrix of Detailed Report**

- Provides a detailed breakdown of payment status, branch, STO (Sales Territory Office), total amount, percentage, and count for both paid and unpaid transactions.

**Status and Total of Payment**

- Visualizes the overall payment status (paid vs. unpaid) as a pie chart, showing the proportion of each category.

**Day by Day Growth of Totag**

- Tracks the daily fluctuations in total revenue or payments over a specified period.

**CONCLUSION**

The **Customer Caring Integrated Platform** successfully addresses the need for a secure and streamlined system to manage customer data. With role-based access, interactive dashboards, and comprehensive data management capabilities, this platform helps customer service teams to efficiently handle their daily tasks and make informed decisions. The combination of security features, such as OTP login via Telegram, and powerful data visualization tools makes this platform an essential tool for managing customer relationships and driving business growth.

**FIGURES**

![](https://github.com/robbytbg/Customer-Caring-Platform/blob/4c599ec626e0c0874f7ad10240c7acb90db9d33c/related%20images/Aspose.Words.d5885a87-a8bc-42f3-a8cb-803caf7c8d57.008.jpeg)

![](https://github.com/robbytbg/Customer-Caring-Platform/blob/4c599ec626e0c0874f7ad10240c7acb90db9d33c/related%20images/Aspose.Words.d5885a87-a8bc-42f3-a8cb-803caf7c8d57.009.jpeg)

![](https://github.com/robbytbg/Customer-Caring-Platform/blob/4c599ec626e0c0874f7ad10240c7acb90db9d33c/related%20images/Aspose.Words.d5885a87-a8bc-42f3-a8cb-803caf7c8d57.010.png)

![](https://github.com/robbytbg/Customer-Caring-Platform/blob/4c599ec626e0c0874f7ad10240c7acb90db9d33c/related%20images/Aspose.Words.d5885a87-a8bc-42f3-a8cb-803caf7c8d57.011.png)

![](https://github.com/robbytbg/Customer-Caring-Platform/blob/4c599ec626e0c0874f7ad10240c7acb90db9d33c/related%20images/Aspose.Words.d5885a87-a8bc-42f3-a8cb-803caf7c8d57.012.png)

![](https://github.com/robbytbg/Customer-Caring-Platform/blob/4c599ec626e0c0874f7ad10240c7acb90db9d33c/related%20images/Aspose.Words.d5885a87-a8bc-42f3-a8cb-803caf7c8d57.013.png)

![](Aspose.Words.d5885a87-a8bc-42f3-a8cb-803caf7c8d57.014.png)

![](Aspose.Words.d5885a87-a8bc-42f3-a8cb-803caf7c8d57.015.png)




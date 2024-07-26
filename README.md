# DBounty Manager Backend

## Overview

The **DBounty Manager Backend** is the server-side application that supports the functionalities for company managers on the DBounty platform. Developed with Laravel, this backend handles tasks related to managing bug bounty programs, overseeing reports, and user management. It communicates with the Manager Frontend and Ethereum smart contracts to facilitate these functions.

## Features

- **Program Management:** APIs for creating, updating, and managing bug bounty programs.
- **Report Management:** Endpoints for overseeing and processing vulnerability reports submitted by researchers.
- **User Management:** Manage and configure team members with roles and permissions.
- **Smart Contract Interaction:** Interfaces with Ethereum smart contracts for managing program rewards and interactions.
- **Real-Time Communication:** Supports WebSocket connections for real-time updates and notifications.

## Application Structure

The Manager Backend is organized into:

- **Controllers:** Handle HTTP requests and responses related to program and report management.
- **Models:** Define and interact with database entities related to programs, reports, and users.
- **Services:** Implement business logic for managing programs, reports, and user roles.
- **Middleware:** Provides request filtering and authentication for backend endpoints.
- **Routes:** Define API endpoints for various backend functionalities.

## License
This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.

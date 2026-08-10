# Scopus Literature Miner (v1.0.0)

A stateless web application built with PHP Native MVC architecture for automated Scopus metadata extraction. This tool utilizes a Bring-Your-Own-Key (BYOK) paradigm and client-side JavaScript Blob API to instantly generate Research Information Systems (RIS) and CSV files without persistent server-side storage.

## Features
*   **Stateless Architecture:** Zero persistent server-side data growth (0 Bytes database footprint).
*   **Bring-Your-Own-Key (BYOK):** Authenticate dynamically via the client-side UI. No hardcoded API keys.
*   **Client-Side Encapsulation:** Real-time generation of RIS and CSV files using JavaScript Blob API.
*   **High Interoperability:** 100% field-level metadata mapping accuracy compatible with Mendeley and Zotero.
*   **Security:** Output encoding for XSS prevention and CSV formula injection mitigation.

## Requirements
*   PHP 8.1 or higher
*   Web Server (Apache/Nginx)
*   MySQL/MariaDB (only for configuration setup, tables remain stateless)
*   Modern Web Browser (Google Chrome v124+ recommended)

## Installation Guide
1. Clone this repository to your web server's root directory:
   ```bash
   git clone [https://github.com/mfurqanhakim139/ScopusMUT.git](https://github.com/mfurqanhakim139/ScopusMUT.git)

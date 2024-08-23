from local import HomeControl

if __name__ == "__main__":
    # Initialize HomeControl with your specific COM port and baud rate
    home_control = HomeControl('COM4', 9600)
    # Run the main loop
    home_control.main_loop()

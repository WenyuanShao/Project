//
//  ViewController.m
//  Sample login
//
//  Created by 邵闻远 on 20/04/2017.
//  Copyright © 2017 shaowy. All rights reserved.
//

#import "ViewController.h"
#import "SBJson.h"
#import "ScanViewController.h"

@interface ViewController ()

@end

@implementation ViewController
@synthesize str;

- (void)viewDidLoad {
    [super viewDidLoad];
    // Do any additional setup after loading the view, typically from a nib.
}

//success
- (void)didReceiveMemoryWarning {
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (void)alertStatus:(NSString *)msg : (NSString *)title {
    UIAlertView *alertView = [[UIAlertView alloc] initWithTitle:title
                                                        message:msg
                                                       delegate:self
                                              cancelButtonTitle:@"Continue"
                                              otherButtonTitles:@"Back", nil];
    [alertView show];
}

- (void)alertView:(UIAlertView *)alertView clickedButtonAtIndex:(NSInteger)buttonIndex {
    NSString *title = [alertView buttonTitleAtIndex:buttonIndex];
    if ([title isEqualToString:@"Continue"]) {
        NSLog(@"Continue...");
        NSLog(@"Str = %@",str);
        [self performSegueWithIdentifier: @"createlogin" sender:self];
    }
}

- (void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender {
    
    if ([segue.identifier isEqualToString:@"createlogin"]) {
        ）
        ScanViewController *scanviewcontroller = segue.destinationViewController;
        scanviewcontroller.str1 = str;
        NSLog(@"finish transfer!");
        
        //		[self.navigationController pushViewController:receive animated:YES];
    }
}

//failed
- (void)alertFailed:(NSString *)msg : (NSString *)title {
    UIAlertView *alertView = [[UIAlertView alloc] initWithTitle:title
                                                        message:msg
                                                       delegate:self
                                              cancelButtonTitle:@"Try-again"
                                              otherButtonTitles:nil, nil];
    [alertView show];
}




- (IBAction)loginbutton:(id)sender {
    @try {
        if ([[_Gid text] isEqualToString:@""] || [[_password text] isEqualToString:@""]) {
            [self alertFailed:@"Please enter both Gid and Password" :@"Login Failed"];
        } else {
            NSString *post = [[NSString alloc] initWithFormat:@"gid=%@&password=%@", [_Gid text],[_password text]];
            NSLog(@"PostData: %@",post);
            
            NSURL *url = [NSURL URLWithString:@"http://172.20.10.5/php/demo/json.php"];
            
            NSData *postData = [post dataUsingEncoding:NSASCIIStringEncoding allowLossyConversion:YES];
            
            NSString *postLength = [NSString stringWithFormat:@"%d", [postData length]];
            
            NSMutableURLRequest *request = [[NSMutableURLRequest alloc] init];
            [request setURL:url];
            [request setHTTPMethod:@"POST"];
            [request setValue:postLength forHTTPHeaderField:@"Content-Length"];
            [request setValue:@"application/json" forHTTPHeaderField:@"Accept"];
            [request setValue:@"application/x-www-form-urlencoded" forHTTPHeaderField:@"Content-Type"];
            [request setHTTPBody:postData];
            
            NSError *error = [[NSError alloc] init];
            NSHTTPURLResponse *response = nil;
            NSData *urlData = [NSURLConnection sendSynchronousRequest:request returningResponse:&response error:&error];
            
            NSLog(@"Response code: %d", [response statusCode]);
            if ([response statusCode] >= 200 && [response statusCode] < 300) {
                NSString *responseData = [[NSString alloc]initWithData:urlData encoding:NSUTF8StringEncoding];
                NSLog(@"Response ==> %@", responseData);
                
                SBJsonParser *jsonParser = [SBJsonParser new];
                NSDictionary *jsonData = (NSDictionary *)[jsonParser objectWithString:responseData error:nil];
                NSLog(@"%@", jsonData);
                NSInteger success = [(NSNumber *) [jsonData objectForKey:@"success"] integerValue];
                NSLog(@"%d", success);
                if(success == 1) {
                    NSLog(@"Login success");
                    
                    
                    
                    str = [_Gid text];
                    NSLog(@"str = %@",str);
                    ScanViewController *scanviewcontroller = [[ScanViewController alloc] initWithNibName:@"ScanViewController" bundle:nil];
                    scanviewcontroller.str1 = str;
                    NSLog(@"str1 = %@",scanviewcontroller.str1);
                    //[self.navigationController pushViewController:scanviewcontroller animated:YES];
                    
                    
                    
                    [self alertStatus:@"Logged in successfully" :@"Login Success!"];
                } else {
                    NSString *error_msg = (NSString *)[jsonData objectForKey:@"error_message"];
                    [self alertFailed:error_msg :@"Login Failure! Correct your credentials"];
                }
            } else {
                if (error) {
                    NSLog(@"Error: %@", error);
                    [self alertFailed:@"Connection Failed" :@"Login Failed!"];
                }
            }
        }
    } @catch (NSException *e) {
        NSLog(@"Exception: %@", e);
        [self alertFailed:@"Login Failed" :@"Login Failed!"];
    }
}
@end




















